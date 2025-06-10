<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $requestedSchemas = explode(',', $request->input('schema'));

        $subcategory = [
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image ? asset($this->image) : null,
            'products' => $this->products->count(),
        ];

        if (in_array(Subcategory::SUBSUBCATEGORIES, $requestedSchemas)) {
            $subcategory['sub_subcategory'] = SubSubCategoryResource::collection($this->subsubCategories);
        }

        $subcategory['brands'] = BrandResource::collection($this->products->pluck('brand')->unique());

        return $subcategory;

    }
}
