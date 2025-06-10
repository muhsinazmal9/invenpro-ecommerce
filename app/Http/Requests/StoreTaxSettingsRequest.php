<?php

namespace App\Http\Requests;

use App\Models\TaxSettings;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaxSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(TaxSettings::TAX_SETTINGS)) {
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
            'code' => 'required|unique:tax_settings,code',
            'rate' => 'required|numeric|max:100|min:0',
        ];
    }
}
