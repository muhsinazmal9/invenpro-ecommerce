<?php

namespace App\Http\Requests;

use App\Models\Newsletter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsLetterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! checkUserPermission(Newsletter::UPDATE)) {
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
        // return [
        //     'subject' => 'required',
        //     'body' => 'required',
        //     'receiver' => 'nullable',
        // ];

        $validation = [
            'subject' => 'required',
            'body' => 'required',
        ];

        if (! $this->select_all) {
            $validation['to_emails'] = 'required';
        }

        return $validation;

    }
}
