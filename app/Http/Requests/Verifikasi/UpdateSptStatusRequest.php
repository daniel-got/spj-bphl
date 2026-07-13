<?php

namespace App\Http\Requests\Verifikasi;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSptStatusRequest extends FormRequest
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
            'status' => 'required|string|in:disetujui,direvisi,ditolak',
            'catatan_verifikator' => 'required_if:status,direvisi,ditolak|nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_verifikator.required_if' => 'Catatan verifikasi wajib diisi jika dokumen direvisi atau ditolak.',
        ];
    }
}
