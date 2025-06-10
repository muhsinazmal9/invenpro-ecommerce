<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\MailService;
use Illuminate\Http\Response;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use App\Http\Resources\OrderResource;
use App\Services\DeliveryScheduleService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Controllers\Api\V1\CheckoutController as ApiCheckoutController;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private OrderService $orderService,
        private MailService $mailService,
        private ApiCheckoutController $apiCheckoutController
    ) {
        //Check user Permissions
        $this->middleware('can:' . Order::LIST)->only('index', 'getList');
        $this->middleware('can:' . Order::STATUS_UPDATE)->only(['status', 'cancelRequestUpdate', 'paymentStatusUpdate']);
        $this->middleware('can:' . Order::DETAILS_VIEW)->only(['invoicePdfStream', 'invoicePdfDownload']);
        $this->middleware('can:' . Order::GIFT_STATUS_UPDATE)->only(['giftStatusUpdate']);
    }

    public function index(): View
    {
        return view('backend.order.index');
    }

    /**
     * Display the specified resource.
     */
    public function create()
    {
        $deliverySchedules = new DeliveryScheduleService();
        $deliverySchedules = $deliverySchedules->getSchedules();
        $country = collect(json_decode(file_get_contents(base_path('json/countries.json')), true))->firstWhere('id', getSetting('country_id'));

        return view('backend.order.create', compact('deliverySchedules', 'country'));
    }

    public function show(Order $order): View
    {
        $shipping_address = json_decode($order->shipping_address, true);
        $billing_address = json_decode($order->billing_address, true);

        return view('backend.order.details', compact('order', 'shipping_address', 'billing_address'));
    }

    public function cancelRequestUpdate(Request $request, Order $order): JsonResponse
    {

        if (!in_array($request->status, [Order::CANCEL_REQUEST['approved'], Order::CANCEL_REQUEST['rejected']])) {
            return error('Invalid status', 403, $request->status);
        }

        $input = [
            'is_cancel_request' => $request->status,
        ];

        if ($request->status == Order::CANCEL_REQUEST['approved']) {
            $input['order_status'] = Order::ORDER_STATUS['cancelled'];
        }

        if($request->status == Order::CANCEL_REQUEST['rejected']) {
            $input['order_status'] = Order::ORDER_STATUS['placed'];
        }

        $order->update($input);

        $this->mailService->sendOrderCancellationMail($order, $order->user);

        return success('Cancel request updated successfully');
    }

    public function getList(Request $request): JsonResponse
    {
        $orders = $this->orderService->getList($request);

        if ($orders->getData()->success) {
            return response()->json($orders->getData()->data);
        }

        return response()->json([]);
    }

    public function status(Request $request, Order $order): JsonResponse
    {

        $order = $this->orderService->status($request, $order);

        if ($order->getData()->success) {
            return success('Order status updated successfully');
        }

        return error($order->getData()->message);
    }

    public function paymentStatusUpdate(Request $request, Order $order): JsonResponse
    {

        try {
            if (!$request->input('status') || !in_array($request->input('status'), [Order::PAYMENT_STATUS['pending'], Order::PAYMENT_STATUS['paid']])) {
                return error(__('app.invalid_payment_status'));
            }

            $order->update([
                'payment_status' => $request->input('status'),
            ]);

            // update transaction status.

            $transactionStatus = match ($request->input('status')) {
                Order::PAYMENT_STATUS['paid'] => Transaction::STATUS['success'],
                Order::PAYMENT_STATUS['pending'] => Transaction::STATUS['pending'],
                default => Transaction::STATUS['failed'],
            };

            if ($order->transaction) {
                $order->transaction->update([
                    'status' => $transactionStatus,
                ]);
            }

            return success('Payment status updated', $order);
        } catch (\Exception $e) {
            logError('Order Payment Status Error ', $e);

            return error('Something went wrong');
        }
    }

    public function giftStatusUpdate(Request $request, Order $order): JsonResponse
    {
        try {

            $giftWrapperCharge = floatval(getSetting(Settings::GIFT_WRAPPING_CHARGE));

            if ($request->input('status') == '1') {

                $order->update([
                    'is_gift' => $request->input('status'),
                    'gift_wrapper_charge' => $giftWrapperCharge,
                    'grand_total' => $order->grand_total + $giftWrapperCharge,
                ]);
            } else {
                $order->update([
                    'is_gift' => $request->input('status'),
                    'gift_wrapper_charge' => 0,
                    'grand_total' => $order->grand_total - $giftWrapperCharge,

                ]);
            }

            return success('Gift status updated', $order);
        } catch (\Exception $e) {
            logError('Gift Status Error ', $e);

            return error('Something went wrong');
        }
    }

    public function invoicePdfStream(Order $order): Response
    {
        return $this->generateInvoice($order, 'stream');
    }

    public function invoicePdfDownload(Order $order): Response
    {
        return $this->generateInvoice($order);
    }

    private function generateInvoice(Order $order, $type = 'download'): Response
    {

        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        $pdf->setPaper('a4', 'portrait');

        $pdf->set_option('enable_php', true);

        $invoice_name = 'invoice-' . $order->invoice_id . '.pdf';

        if ($type == 'stream') {
            return $pdf->stream($invoice_name);
        }

        return $pdf->download($invoice_name);
    }
    public function getUserOrderList(Request $request, User $user): JsonResponse
    {
        $orders = $this->orderService->getUserOrderList($request, $user);

        if ($orders->getData()->success) {
            return response()->json($orders->getData()->data);
        }

        return response()->json([]);
    }
}
