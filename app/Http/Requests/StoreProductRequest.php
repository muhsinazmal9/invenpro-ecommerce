<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return checkUserPermission(Product::CREATE);
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
            'price' => [
                Rule::requiredIf(fn () => empty($this->variants)),
                'nullable',
                'numeric',
                'min:0',
            ],
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|required_with:discount|in:FIXED,PERCENTAGE',
            'stock' => [
                Rule::requiredIf(fn () => empty($this->variants)),
                'nullable',
                'numeric',
                'min:0',
            ],
            'variants' => 'nullable|array',
            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.stock' => ['required', 'numeric', 'min:0'],
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'subsub_category_id' => 'nullable|exists:subsub_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'featured' => 'nullable|boolean',
            'new_arrival' => 'nullable|boolean',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'custom_attributes' => 'nullable|array',
            'custom_attributes.*.key' => 'required|string',
            'custom_attributes.*.value' => 'required|string',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'price.required' => 'The price is required when no variants are provided or variants are empty.',
            'stock.required' => 'The stock is required when no variants are provided or variants are empty.',
        ];
    }
}