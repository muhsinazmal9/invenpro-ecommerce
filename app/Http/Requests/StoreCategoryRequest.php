<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Category::CREATE)) {
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
            'name' => 'required|unique:categories,name,NULL,NULL,deleted_at,NULL',
            'image' => 'required',
            'status' => 'boolean',
            'show_in_quick_menu' => 'boolean',
            'show_in_home_page' => 'boolean',
        ];
    }
}
