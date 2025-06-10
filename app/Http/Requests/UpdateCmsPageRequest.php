<?php

namespace App\Http\Requests;

use App\Models\CmsPage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCmsPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(CmsPage::CREATE)) {
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
            'title' => 'required|unique:cms_pages,title,'.$this->page->id,
            'content' => 'required',
            'slug' => 'unique:cms_pages,slug,'.$this->page->id,
        ];
    }
}
