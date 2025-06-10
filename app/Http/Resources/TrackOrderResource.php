<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackOrderResource extends JsonResource
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
            'status' => $this->order_status,
            'status_logs' => $this->statusLogs(Order::ORDER_STATUS, $this->order_status),
            'created_at' => $this->created_at,
        ];
    }

    private function statusLogs(array $statuses, string $currentStatus = null): array
    {
        if ($currentStatus === null) {
            return [];
        }

        $result = [];
        $setValue = true;

        foreach ($statuses as $status) {
            $result[$status] = $setValue ? ($this->orderLogs()?->status()?->where('activity', $status)?->first()?->created_at?->format('h:i A, d M Y') ?? null) : null;

            if ($status === $currentStatus) {
                $setValue = false;
            }
        }

        return $result;
    }
}
