<?php

namespace App\Observers;

use App\Mail\OrderApproveMail;
use App\Mail\OrderCancellationMail;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {

        $orderStatusLog = OrderLog::create([
            'order_id' => $order->id,
            'event' => OrderLog::STATUS_UPDATE,
            'activity' => $order->order_status,
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {

        $previousStatus = $order->orderLogs()->latest()->first();

        if ($previousStatus->order_status != $order->order_status) {

            if ($order->order_status == Order::ORDER_STATUS['approved']) {

                try {
                    Mail::to($order->user?->email)->send(new OrderApproveMail($order->user, $order));
                } catch (\Exception $e) {
                    logError('Order Approve Mail Error ', $e);
                }
            }
            if ($order->order_status == Order::ORDER_STATUS['cancelled']) {

                try {
                    Mail::to($order->user?->email)->send(new OrderCancellationMail($order->user, $order));
                } catch (\Exception $e) {
                    logError('Order Cancel Mail Error ', $e);
                }
            }

            OrderLog::create([
                'order_id' => $order->id,
                'event' => OrderLog::STATUS_UPDATE,
                'activity' => $order->order_status,
            ]);
        }

    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
