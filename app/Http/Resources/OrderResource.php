<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'delivery_instruction' => $this->delivery_instruction,
            'delivery_time' => $this->delivery_time,
            'estimated_delivery_date' => $this->delivery_date,
            'delivery_type' => $this->delivery_type,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'discount' => $this->discount,
            'order_status' => $this->order_status,
            'subtotal' => $this->subtotal,
            'shipping_charge' => $this->shipping_charge,
            'service_amount' => $this->service_amount,
            'gift_wrapper_charge' => $this->gift_wrapper_charge,
            'tax' => $this->tax,
            'grand_total' => $this->grand_total,
            'is_cancel_request' => getCancelRequestStatus($this->is_cancel_request),
            'created_at' => $this->created_at,
            'products' => OrderProductResource::collection($this->products),
        ];
    }
}
