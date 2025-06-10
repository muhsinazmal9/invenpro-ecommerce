<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $discount = 0;
        if ($this->discount) {
            switch ($this->discount_type) {
                case 'FIXED':
                    $discount = $this->discount;
                    break;
                case 'PERCENTAGE':
                    $discount = $this->price * $this->discount / 100;
                    break;
                default:
                    break;
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail ? asset($this->thumbnail) : null,
            'size_chart' => $this->size_chart ? asset($this->size_chart) : null,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'sku' => $this->sku,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'stock' => $this->stock,
            'seo_title' => $this->seo_title,
            'keywords' => $this->keywords,
            'seo_description' => $this->seo_description,
            'featured' => $this->featured,
            'new_arrival' => $this->new_arrival,
            'tax' => $this->tax ? (($this->price - $discount) * $this->tax->rate) / 100 : 0.0,
            'category' => new CategoryResource($this->category),
            'subcategory' => new SubcategoryResource($this->subcategory),
            'sub_subcategory' => new SubSubCategoryResource($this->subsubCategory),
            'brand' => new BrandResource($this->brand),
            'images' => $this->toSingleArray($this->images, 'full_url'),
            'attributes' => ProductAttributeResource::collection($this->attributes),
            'custom_attributes' => ProductCustomAttributeResource::collection($this->customAttributes),
            'tags' => $this->toSingleArray($this->tags, 'title'),
            'reviews' => ProductReviewResource::collection($this->reviews),
            'rating' => [
                1 => $this->reviews->where('rating', 1)->count(),
                2 => $this->reviews->where('rating', 2)->count(),
                3 => $this->reviews->where('rating', 3)->count(),
                4 => $this->reviews->where('rating', 4)->count(),
                5 => $this->reviews->where('rating', 5)->count(),
                'avg' => $this->ratting
            ],
        ];
    }

    private function toSingleArray(Collection $model, string $key): array
    {
        $data = [];

        foreach ($model as $model) {
            $data[] = $model->{$key};
        }

        return $data;
    }
}
