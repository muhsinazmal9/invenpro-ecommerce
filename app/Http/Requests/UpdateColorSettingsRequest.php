<?php

namespace App\Http\Requests;

use App\Models\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UpdateColorSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Settings::COLOR_SETTING)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
