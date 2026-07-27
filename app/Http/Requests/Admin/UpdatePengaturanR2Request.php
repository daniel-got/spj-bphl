<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePengaturanR2Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'r2_endpoint' => ['required', 'url'],
            'r2_bucket' => ['required', 'string', 'max:255'],
            'r2_access_key' => ['required', 'string', 'max:255'],
            // Secret key bersifat opsional saat update (kosong = tidak mengubah nilai lama)
            'r2_secret_key' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'r2_endpoint' => 'Endpoint URL',
            'r2_bucket' => 'Nama Bucket',
            'r2_access_key' => 'Access Key ID',
            'r2_secret_key' => 'Secret Access Key',
        ];
    }
}
