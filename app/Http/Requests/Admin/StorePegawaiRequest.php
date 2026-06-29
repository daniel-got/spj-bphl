<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StorePegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pegawai'     => ['required', 'string', 'max:255'],
            'nip'              => ['required', 'string', 'max:50', Rule::unique('data_pegawai', 'nip')],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8'],
            'role'             => ['required', 'string', Rule::in(\App\Enums\UserRole::values())],
            'pangkat'          => ['nullable', 'string', Rule::in(\App\Enums\Pangkat::values())],
            'golongan'         => ['nullable', 'string', Rule::in(\App\Enums\Golongan::values())],
            'jabatan'          => ['nullable', 'string', 'max:100'],
            'sub_seksi'        => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Kustomisasi pesan error (opsional).
     */
    public function messages(): array
    {
        return [
            'nip.unique' => 'NIP sudah terdaftar di sistem.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'role.in' => 'Role akses yang dipilih tidak valid.',
        ];
    }
}
