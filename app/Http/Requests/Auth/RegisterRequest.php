<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:4', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'min:6', 'confirmed'],
            'birth_date' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => "Bro, don't you have a name?",
            'username.min' => "It can't be this short bro.",
            'password.required' => 'You want everyone to access to your account?',
            'password.min' => 'You want your account to get cracked that badly?'
        ];
    }
}
