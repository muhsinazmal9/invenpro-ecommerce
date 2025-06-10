<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->attribute->product;

        if ($product) {
            $price = $product->price;

            if ($product->discount) {
                switch ($product->discount_type) {
                    case 'FIXED':
                        $price -= $product->discount;
                        break;
                    case 'PERCENTAGE':
                        $price -= ($price * $product->discount) / 100;
                        break;
                    default:
                        break;
                }
            }

            $adjustedPrice = $price + ($this->price_adjustment ?? 0);
            $totalTax = $product && $product->tax && $product->tax->rate ? ($adjustedPrice * $product->tax->rate) / 100 : 0;
        } else {
            $adjustedPrice = $totalTax = 0;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            //'price' => $product ? ($adjustedPrice + $totalTax) : 0,
            'adjusted_price' => $this->price_adjustment ?? 0,
            'tax' => $product ? $totalTax : 0,
            'code' => $this->code,
        ];
    }
}
