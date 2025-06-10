<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $productJson = json_decode($this->product_json, true);

        return [
            'title' => $productJson['title'],
            'product_slug' => $productJson['slug'],
            'thumbnail' => $productJson['thumbnail'] ? asset($productJson['thumbnail']) : null,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'is_reviewed' => (bool) $this->isReviewed(),
            'meta' => json_decode($this->meta, true),
        ];
    }
}
