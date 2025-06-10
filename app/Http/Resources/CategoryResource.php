<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $requestedSchemas = $request->input('schema') 
            ? array_filter(explode(',', $request->input('schema')))
            : [];

        $category = [
            'title' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image ? asset($this->image) : null,
            'products' => $this->products->count(),
            'show_in_quick_menu' => (bool) $this->show_in_quick_menu,
            'show_in_home_page' => (bool) $this->show_in_home_page,
        ];

        if (in_array(Category::SUBCATEGORIES, $requestedSchemas)) {
            $category['subcategories'] = SubcategoryResource::collection($this->subcategories);
        }

        if (in_array(Category::BRANDS, $requestedSchemas)) {
            $category['brands'] = BrandResource::collection($this->products->pluck('brand')->unique());
        }

        if (in_array(Category::RATINGS, $requestedSchemas)) {
            $category['ratings'] = [
                numberToWord(1) => $this->products->filter(function ($product) {
                    return round($product->ratting) == 1;
                })->count(),

                numberToWord(2) => $this->products->filter(function ($product) {
                    return round($product->ratting) == 2;
                })->count(),

                numberToWord(3) => $this->products->filter(function ($product) {
                    return round($product->ratting) == 3;
                })->count(),

                numberToWord(4) => $this->products->filter(function ($product) {
                    return round($product->ratting) == 4;
                })->count(),

                numberToWord(5) => $this->products->filter(function ($product) {
                    return round($product->ratting) == 5;
                })->count(),
            ];
        }

        return $category;

    }
}
