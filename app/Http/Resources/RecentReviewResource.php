<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'files' => json_decode($this->files),
            'user_name' => $this->user->name,
            'product_thumbnail' => $this->product->thumbnail ? asset($this->product->thumbnail) : null,
            'product_title' => $this->product->title,
            'product_slug' => $this->product->slug,
        ];
    }
}
