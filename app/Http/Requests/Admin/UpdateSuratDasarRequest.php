<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratDasarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'teks' => 'required|string',
            'jenis_spt' => 'nullable|string|max:50',
            'aktif' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'teks.required' => 'Isi teks surat dasar wajib diisi.',
        ];
    }
}
