<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * --------------------------------------------------------------------------
     * Authorization
     * --------------------------------------------------------------------------
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * --------------------------------------------------------------------------
     * Validation Rules
     * --------------------------------------------------------------------------
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ];
    }

    /**
     * --------------------------------------------------------------------------
     * Custom Messages
     * --------------------------------------------------------------------------
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',

        ];
    }
}