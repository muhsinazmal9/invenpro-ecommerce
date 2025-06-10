<?php

namespace App\Http\Controllers\Api\V1;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Settings;
use App\Constants\Activity;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PromoResource;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        if (!auth()->check()) {
            return error('Unauthorized', 403);
        }
        info('CheckoutController@checkout', $request->all());

        try {
            $validation = $this->validateRequest($request);

            if ($validation->fails()) {
                return error('Validation error', 403, $validation->errors());
            }

            if ($request->promo_code) {
                $promo = $this->getPromo($request);
                $promo = $promo->getData()->data;
            }

            $products = json_decode($request->products);

            $missingProducts = $this->getMissingProducts($products);
            if (!empty($missingProducts)) {
                return error('products not found', 403, ['product IDs' => $missingProducts]);
            }

            $order = $this->createOrder($request);
            $allAmount = $this->storeOrderProductAndGetAmount($request, $order);

            $discount = 0;
            $subtotal = $allAmount['subtotal'];

            if (isset($promo)) {
                $discount = $promo->discount;
                if ($promo->discount_type == Promo::DISCOUNT_TYPE['percentage']) {
                    $discount = $allAmount['subtotal'] * ($discount / 100);
                }
                $subtotal = $allAmount['subtotal'] - $discount;
                Promo::where('code', $request->promo_code)->decrement('limit', 1);
            }
            // info($order->is_gift_wrapping);

            $giftWrapperCharge = ($order->is_gift && $order->is_gift_wrapping) ? floatval(getSetting(Settings::GIFT_WRAPPING_CHARGE)) : 0;
            $tax = $allAmount['total_tax'];
            $serviceAmount = floatval(getSetting(Settings::SERVICE_CHARGE));
            $shippingCharge = floatval(getSetting(Settings::SHIPPING_CHARGE));
            $grandTotal = $subtotal + $tax + $serviceAmount + $shippingCharge + $giftWrapperCharge;

            $order->update([
                'gift_wrapper_charge' => $giftWrapperCharge,
                'tax' => $tax,
                'service_amount' => $serviceAmount,
                'subtotal' => $allAmount['subtotal'],
                'shipping_charge' => $shippingCharge,
                'promo' => isset($promo) ? json_encode($promo) : null,
                'discount' => $discount,
                'grand_total' => $grandTotal,
            ]);

            if ($request->payment_method == 'online' && $request->online_payment_method == 'stripe') {
                $stripeSecretKey = getSetting(Settings::STRIPE_SECRET_KEY);
                Stripe::setApiKey($stripeSecretKey);

                if ($request->input('is_admin')) {
                    $successUrl = route('admin.transactions.payment.success', $order);
                    $cancelUrl = route('admin.transactions.payment.fail', $order);
                } else {
                    $successUrl = config('app.frontend_url') . "/pages/orders/payment/success/{$order->id}";
                    $cancelUrl = config('app.frontend_url') .  "/pages/orders/payment/failed/{$order->id}";
                }

                $paymentData = [
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->invoice_id,
                            ],
                            'unit_amount' => $grandTotal * 100,
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                ];

                $session = \Stripe\Checkout\Session::create($paymentData);
                $order->stripe_session_id = $session->id;
                $order->save();
                info('session' . $order->id, ['session' => $session]);

                return success('Order payment processing', ['url' => $session->url]);
            }

            if (!empty($order->payment_status) && $order->payment_method != 'bkash') {
                $this->addTransaction($order);
            }

            activity()
                ->performedOn(new Order())
                ->causedBy(auth()->user())
                ->event(Activity::CREATED)
                ->withProperties([
                    Activity::CREATED => $order->toArray(),
                ])->log('Created Order ' . $order->invoice_id);
            return success('Order placed successfully', new OrderResource($order->load('products')));
        } catch (\Exception $e) {
            info('CheckoutController@checkout', ['error' => $e->getMessage()]);

            return error('Something went wrong', 500);
        }
    }

    public function addTransaction(Order $order, $status = Transaction::STATUS['pending'], $bkashData = [])
    {
        $validationData = [
            'amount' => $order->grand_total,
            'payment_method' => $order->payment_method,
        ];
        
        $validationRules = [
            'amount' => 'required|numeric|min:0|max:999999999',
            'payment_method' => [
                'required',
                Rule::in([
                    Order::PAYMENT_METHOD['cod'],
                    Order::PAYMENT_METHOD['online'],
                    Order::PAYMENT_METHOD['bkash'],
                ]),
            ],
        ];
        
        if ($order->payment_method == Order::PAYMENT_METHOD['bkash']) {
            $validationData = array_merge($validationData, [
                'bkash_transaction_id' => $bkashData['bkash_transaction_id'] ?? null,
                'bkash_account_number' => $bkashData['bkash_account_number'] ?? null,
            ]);
        
            $validationRules = array_merge($validationRules, [
                'bkash_transaction_id' => 'required',
                'bkash_account_number' => 'required|numeric|digits:11',
            ]);
        }
        
        $validation = Validator::make($validationData, $validationRules);

        if ($validation->fails()) {
            return error('Validation error', 403, $validation->errors());
        }

        $paymentMethod = match ($order->payment_method) {
            Order::PAYMENT_METHOD['cod'] => Transaction::PAYMENT_METHOD['cod'],
            Order::PAYMENT_METHOD['online'] => Transaction::PAYMENT_METHOD['online'],
            Order::PAYMENT_METHOD['bkash'] => Transaction::PAYMENT_METHOD['bkash'],
        };

        $order->transaction()->create([
            'user_id' => $order->user_id,
            'transaction_id' => $this->invoiceGenerator(),
            'reference' => 'Checkout',
            'amount' => $order->grand_total,
            'payment_method' => $paymentMethod,
            'status' => $order->payment_method == Order::PAYMENT_METHOD['cod'] ? Transaction::STATUS['pending'] : $status,
            'currency' => getSetting(Settings::DEFAULT_CURRENCY),
            'bkash_transaction_id' => $bkashData['bkash_transaction_id'] ?? null,
            'bkash_account_number' => $bkashData['bkash_account_number'] ?? null,
        ]);
    }

    private function createOrder(Request $request)
    {
        if ($request->input('is_admin')) {
            $user_id = $request->input('user_id');
        } else {
            $user_id = Auth('sanctum')->user()?->id;
        }

        $order = Order::create([
            'invoice_id' => $this->invoiceGenerator(),
            'user_id' => $user_id,
            // 'user_id' => $request->user()?->id,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'delivery_instruction' => $request->delivery_instruction,
            'delivery_date' => $request->delivery_date,
            'payment_method' => $request->payment_method,
            'is_gift' => (bool) $request->is_gift,
            'is_gift_wrapping' => (bool) $request->is_gift_wrapping,
            'gift' => $request->gift,
            'delivery_type' => Order::DELIVERY_TYPE['delivery'],
            'payment_status' => Order::PAYMENT_STATUS['pending'],
            'order_status' => Order::ORDER_STATUS['placed'],
        ]);

        return $order;
    }

    private function storeOrderProductAndGetAmount(Request $request, Order $order)
    {
        info('CheckoutController@storeOrderProductAndGetAmount', $request->all());
        $totalPrice = 0;
        $totalTax = 0;
        $products = json_decode($request->products);

        foreach ($products as $product) {

            $productCollection = Product::with('category', 'subcategory', 'brand', 'tags', 'attributes', 'images', 'tax')->find($product->id);

            if (empty($productCollection)) {
                return [
                    'status' => false,
                    'message' => "Product: {$product->id} is not exists",
                ];
            }



            $price = $productCollection->price;

            switch ($productCollection->discount_type) {
                case 'FIXED':
                    $price -= $productCollection->discount;
                    break;
                case 'percentage':
                    $price -= ($price * ($productCollection->discount / 100));
                    break;
            }

            $price *= $product->quantity;

            $tax = $productCollection->tax ? $this->calculateTax($price, $productCollection->tax?->rate) : 0;

            $totalPrice += $price;
            $totalTax += $tax;

            $productJson = json_encode($productCollection);
            $productAttributeJson = json_encode($product->attributes);

            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productCollection->id,
                'quantity' => $product->quantity,
                'price' => $price ?? 0,
                'product_json' => $productJson,
                'meta' => $productAttributeJson,
            ]);

            $productCollection->stock -= $product->quantity;
            $productCollection->save(); // update stock
        }

        return [
            'status' => true,
            'subtotal' => $totalPrice,
            'total_tax' => round($totalTax, 2),
        ];
    }

    private function calculateTax(float $price, float $taxRate): float
    {
        return $price * ($taxRate / 100);
    }

    private function getPromo(Request $request)
    {
        $promoCode = $request->promo_code;
        $promo = Promo::where('code', $promoCode)->first();

        if (!$promo || $promo->status != Promo::STATUS['active']) {
            $errorMessage = $promo ? 'Promo is not available' : 'Promo not found';
            return error($errorMessage, $promo ? 403 : 404);
        }

        return success('Promo available', new PromoResource($promo));
    }

    private function validateRequest(Request $request)
    {
        return validateData([
            'shipping_address' => 'required',
            'billing_address' => 'required',
            'delivery_instruction' => 'nullable',
            'delivery_date' => 'required',
            'payment_method' => 'required|in:cod,online,bkash',
            'online_payment_method' => 'required_if:payment_method,online',
            'is_gift' => 'nullable|bool',
            'is_gift_wrapping' => 'nullable|bool',
            'gift_message' => 'nullable',
            'products' => 'required',
            'promo_code' => 'nullable',
        ]);
    }

    private function getMissingProducts($products)
    {
        $productIds = array_column($products, 'id');
        $productsExist = Product::published()->whereIn('id', $productIds)->pluck('id')->toArray();

        return array_diff($productIds, $productsExist);
    }

    private function invoiceGenerator(): string
    {

        $prefix = getSetting(Settings::INVOICE_PREFIX);

        $invoice = $prefix . '-' . Str::upper(Str::random(6));

        $i = 1;
        while (Order::where('invoice_id', $invoice)->exists()) {
            $invoice = $prefix . '-' . Str::upper(Str::random(6) . $i);
            $i++;
        }

        return $invoice;
    }
}