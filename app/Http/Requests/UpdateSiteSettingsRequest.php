<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Settings::SITE_SETTINGS)) {
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
            'site_title' => 'required|string|max:255',
            'frontend_url' => 'required|url',
            'default_phone_code' => 'required|string|max:255',
            'default_language' => 'required|string|max:255',
            'default_currency' => 'required|string|max:255',
            'currency_symbol' => 'required|string|max:255',
            'timezone' => 'required|string|max:255',

        ];
    }
}
