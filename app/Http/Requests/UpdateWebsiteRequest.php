<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWebsiteRequest extends FormRequest
{
    /**
     * Semua user yang sudah login boleh mengakses.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validasi update website.
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
                Rule::unique('websites', 'url')->ignore($this->route('website'))
            ],

            'domain' => [
                'required',
                Rule::unique('websites', 'domain')->ignore($this->route('website'))
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
     * Pesan error validasi.
     */
    public function messages(): array
    {
        return [

            'name.required' => 'Nama website wajib diisi.',

            'institution.required' => 'Nama instansi wajib diisi.',

            'url.required' => 'URL wajib diisi.',

            'url.url' => 'Format URL tidak valid.',

            'domain.required' => 'Domain wajib diisi.',

            'status.required' => 'Status wajib dipilih.',

            'status.in' => 'Status hanya boleh active atau inactive.',

        ];
    }
}