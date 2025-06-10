<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLogoSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Settings::LOGO_SETTINGS)) {
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
            'primary_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'secondary_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
