<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportPegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'file' => ['required_without:import_token', 'file', 'mimes:csv,txt', 'max:5120'], // Max 5MB
            'import_token' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File CSV wajib diunggah.',
            'file.mimes' => 'Format file harus berupa CSV.',
            'file.max' => 'Ukuran file maksimal adalah 5MB.',
        ];
    }
}
