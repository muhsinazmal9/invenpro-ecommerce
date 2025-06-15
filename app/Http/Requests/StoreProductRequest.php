<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkUserPermission(Product::CREATE);
    }
    public function prepareForValidation()
    {
        $this->merge([
            'tax_id' => $this->tax_id == 0 ? null : $this->tax_id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
      return [
            'title' => 'required|string|max:255',
            'thumbnail' => 'required',
            'short_description' => 'required|string',
            'sku' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|required_with:discount|in:FIXED,PERCENTAGE',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'subsub_category_id' => 'required|exists:subsub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'featured' => 'nullable|boolean',
            'new_arrival' => 'nullable|boolean',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'tax_id' => 'nullable|integer|exists:tax_settings,id',
            'custom_attributes' => 'nullable|array',
            'custom_attributes.*.key' => 'required|string',
            'custom_attributes.*.value' => 'required|string',
        ]; 
    }
}
