<?php

namespace App\Http\Controllers\Api\V1;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Api\V1\CheckoutController;

class TransactionController extends Controller
{
    public function __construct(private CheckoutController $checkoutController)
    {
        // ...
    }

    public function paymentSuccess(Request $request, Order $order): JsonResponse
    {
        if ($order->payment_status == Order::PAYMENT_STATUS['paid']) {
            return success('Payment Success', new OrderResource($order->load('products')));
        }

        $stripeSecretKey = getSetting(Settings::STRIPE_SECRET_KEY);
        Stripe::setApiKey($stripeSecretKey);

        if ($order->stripe_session_id == null) {
            return error('Payment Failed');
        }

        $session = \Stripe\Checkout\Session::retrieve($order->stripe_session_id);

        if ($session->payment_status != 'paid') {
            return error('Payment Failed');
        }

        $order->payment_status = Order::PAYMENT_STATUS['paid'];
        $order->order_status = Order::ORDER_STATUS['placed'];
        $order->save();

        $this->checkoutController->addTransaction($order, Transaction::STATUS['success']);

        return success('Payment Success', new OrderResource($order->load('products')));
    }

    public function paymentFailed(Request $request, Order $order): JsonResponse
    {
        if ($order->payment_status == Order::PAYMENT_STATUS['failed']) {
            return error('Payment Failed');
        }

        $order->update([
            'payment_status' => Order::PAYMENT_STATUS['failed'],
            'order_status' => Order::ORDER_STATUS['placed'],
        ]);

        $this->checkoutController->addTransaction($order, Transaction::STATUS['failed']);

        return error('Payment Failed');

    }

    public function storeBkashPaymentTransaction(Request $request, Order $order): JsonResponse
    {
        if ($order->transaction()->exists()) {
            return error('Transaction already exists');
        }
        
        $request->validate([
            'bkash_transaction_id' => 'required',
            'bkash_account_number' => 'required|numeric|digits:11',
        ]);

        $order->update([
            'payment_status' => Order::PAYMENT_STATUS['pending'],
            'order_status' => Order::ORDER_STATUS['placed'],
        ]);

        $transaction = $this->checkoutController->addTransaction($order, Transaction::STATUS['pending'], [
            'bkash_transaction_id' => $request->bkash_transaction_id,
            'bkash_account_number' => $request->bkash_account_number,
        ]);

        if ($transaction !== null && $transaction->getData() !== null && is_object($transaction->getData()) && !$transaction->getData()->success) {
            return error($transaction->getData()->message, $transaction->getData()->status, $transaction->getData()->data);
        }

        return success('Order payment processing', new OrderResource($order->load('products')));
    }
}
