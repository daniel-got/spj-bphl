<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratDasarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'teks' => 'required|string|unique:data_surat_dasar,teks',
            'aktif' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'teks.required' => 'Isi teks surat dasar wajib diisi.',
            'teks.unique' => 'Teks surat dasar ini sudah ada di database.',
        ];
    }
}
