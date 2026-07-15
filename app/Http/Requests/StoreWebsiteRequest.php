<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteRequest extends FormRequest
{
    /**
     * Semua user yang sudah login boleh mengakses.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi input tambah website.
     */
    public function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'institution' => [
                'required',
                'string',
                'max:255'
            ],

            'url' => [
                'required',
                'url',
                'unique:websites,url'
            ],

            'domain' => [
                'required',
                'string',
                'unique:websites,domain'
            ],

            'province' => [
                'nullable',
                'string',
                'max:255'
            ],

            'city' => [
                'nullable',
                'string',
                'max:255'
            ],

            'status' => [
                'required',
                'in:active,inactive'
            ],

            'description' => [
                'nullable',
                'string'
            ],

        ];
    }

    /**
     * Pesan error yang lebih mudah dipahami.
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Nama website wajib diisi.',

            'institution.required' => 'Nama instansi wajib diisi.',

            'url.required' => 'URL wajib diisi.',

            'url.url' => 'Format URL tidak valid.',

            'url.unique' => 'URL sudah digunakan.',

            'domain.required' => 'Domain wajib diisi.',

            'domain.unique' => 'Domain sudah digunakan.',

            'status.required' => 'Status wajib dipilih.',

            'status.in' => 'Status hanya boleh active atau inactive.',

        ];
    }
}