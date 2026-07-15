<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationScheduleRequest extends FormRequest
{
    /**
     * Authorize
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'website_id' => [
                'required',
                'exists:websites,id',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'interval_minutes' => [
                'required',
                'integer',
                'min:1',
            ],

            'monday' => [
                'required',
                'boolean',
            ],

            'tuesday' => [
                'required',
                'boolean',
            ],

            'wednesday' => [
                'required',
                'boolean',
            ],

            'thursday' => [
                'required',
                'boolean',
            ],

            'friday' => [
                'required',
                'boolean',
            ],

            'saturday' => [
                'required',
                'boolean',
            ],

            'sunday' => [
                'required',
                'boolean',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [

            'website_id.required' => 'Website wajib dipilih.',

            'website_id.exists' => 'Website tidak ditemukan.',

            'start_time.required' => 'Jam mulai wajib diisi.',

            'end_time.required' => 'Jam selesai wajib diisi.',

            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai.',

            'interval_minutes.required' => 'Interval evaluasi wajib diisi.',

            'interval_minutes.integer' => 'Interval harus berupa angka.',

            'interval_minutes.min' => 'Minimal interval adalah 1 menit.',

        ];
    }
}