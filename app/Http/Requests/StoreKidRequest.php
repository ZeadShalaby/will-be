<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'mother_name' => 'required|string|max:255',
            'mother_phone' => 'nullable|string|max:20',
            'father_name' => 'required|string|max:255',
            'father_phone' => 'nullable|string|max:20',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'guardian_relation' => 'nullable|string|max:100',
            'transport_method' => 'required|in:bus,other',
            'how_did_you_know' => 'nullable|string|max:255',
            'status' => 'in:active,inactive,pending',
            'notes' => 'nullable|string',

            // Child photos
            'child_photos' => 'required|array|min:6|max:6',
            'child_photos.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            // Additional files
            'mother_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'father_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'birth_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // Additional files for medical tests
            'cbc' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'urin' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'stool' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
