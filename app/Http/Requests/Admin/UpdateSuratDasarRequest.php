<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSuratDasarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'teks' => ['required', 'string', Rule::unique('data_surat_dasar', 'teks')->ignore($this->route('surat_dasar'))],
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
