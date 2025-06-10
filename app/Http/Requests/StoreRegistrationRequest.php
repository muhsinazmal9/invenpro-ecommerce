<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'fname' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:users,phone',
            'email' => 'required|email|unique:users,email',
        ];
    }
    public function messages()
    {
        return [
            'fname.required' => 'First name is required',
            'phone.required' => 'Phone number is required', 
            'phone.numeric' => 'Phone number must be numeric',
            'phone.unique' => 'Phone number already exists',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
        ];
    }
    
}
