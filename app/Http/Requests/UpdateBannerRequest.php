<?php

namespace App\Http\Requests;

use App\Models\Banner;
use App\Enums\BannerTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Banner::UPDATE)) {
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

        $rules = [
            'image' => [
                'nullable',
            ],
            'link' => [
                'string',
                'url',
            ],
        ];

        if ($this->banner->type !== BannerTypeEnum::FIXED->value) {
            $rules['title'] = [
                'required',
                'string',
                'unique:banners,title,'.$this->banner->id,
            ];
            $rules['short_description'] = [
                'nullable',
                'string',
            ];
        }

        return $rules;
    }
}
