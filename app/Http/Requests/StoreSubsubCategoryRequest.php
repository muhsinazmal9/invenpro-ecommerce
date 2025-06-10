<?php

namespace App\Http\Requests;

use App\Models\SubsubCategory;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubsubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(SubsubCategory::CREATE)) {
            return false;
        }

        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'subcategory_id' => 'required|exists:subcategories,id',
            'title' => 'required|unique:subcategories,title',

        ];

    }
}
