<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportUangHarianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        // Jika ada import_token, berarti ini proses import sebenarnya
        if ($this->has('import_token')) {
            return [
                'import_token' => 'required|string',
            ];
        }

        // Jika tidak, berarti ini proses validasi/upload awal
        return [
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ];
    }
}
