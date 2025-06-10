<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '1' => $this->reviews->where('rating', 1)->count(),
            '2' => $this->reviews->where('rating', 2)->count(),
            '3' => $this->reviews->where('rating', 3)->count(),
            '4' => $this->reviews->where('rating', 4)->count(),
            '5' => $this->reviews->where('rating', 5)->count(),
        ];
    }
}
