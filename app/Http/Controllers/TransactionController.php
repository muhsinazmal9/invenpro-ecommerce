<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Settings;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Services\TransactionService;
use App\Http\Controllers\Api\V1\CheckoutController as ApiCheckoutController;


class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService,
        private ApiCheckoutController $apiCheckoutController,
    ) {

    }

    public function index(): View
    {
        return view('backend.transactions.index');
    }

    public function paymentSuccess(Request $request, Order $order)
    {
        if ($order->payment_status == Order::PAYMENT_STATUS['paid']) {
            return redirect()->route('admin.orders.show', $order->id);
        }

        $stripeSecretKey = getSetting(Settings::STRIPE_SECRET_KEY);
        Stripe::setApiKey($stripeSecretKey);

        $session = \Stripe\Checkout\Session::retrieve($order->stripe_session_id);
        info('info from payment success', [$session]);

        if ($session->payment_status != 'paid') {
            return redirect()->route('admin.transactions.payment.fail', $order);
        }

        $order->payment_status = Order::PAYMENT_STATUS['paid'];
        $order->order_status = Order::ORDER_STATUS['placed'];
        $order->save();

        $this->apiCheckoutController->addTransaction($order, Transaction::STATUS['success']);

        return redirect()->route('admin.orders.show', $order->id)->with('success', __('app.payment_success'));
    }

    public function paymentFail(Request $request, Order $order)
    {
        if ($order->payment_status == Order::PAYMENT_STATUS['failed']) {
            return redirect()->route('admin.orders.show', $order->id);
        }

        $order->update([
            'payment_status' => Order::PAYMENT_STATUS['failed'],
            'order_status' => Order::ORDER_STATUS['placed'],
        ]);

        $this->apiCheckoutController->addTransaction($order, Transaction::STATUS['failed']);

        return redirect()->route('admin.orders.show', $order->id)->with('error', __('app.payment_failed'));
    }
}
