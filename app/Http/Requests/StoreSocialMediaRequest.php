<?php

namespace App\Http\Requests;

use App\Models\SocialMedia;
use Illuminate\Foundation\Http\FormRequest;

class StoreSocialMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(SocialMedia::SOCIAL_MEDIA_SETTINGS)) {
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
            'username' => 'required',
            'platform_id' => 'required',
        ];
    }
}
