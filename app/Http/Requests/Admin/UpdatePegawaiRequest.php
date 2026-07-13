<?php

namespace App\Http\Requests\Admin;

use App\Enums\Golongan;
use App\Enums\Pangkat;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        // Mendapatkan ID pegawai dari parameter route 'pegawai'
        $pegawai = $this->route('pegawai');

        return [
            'nama_pegawai' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', Rule::unique('data_pegawai', 'nip')->ignore($pegawai->id)],
            // Nanti di Service kita yang cari user-nya dari relasi $pegawai->user_id
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'], // Opsional saat update
            'role' => ['required', 'string', Rule::in(UserRole::values())],
            'pangkat' => ['nullable', 'string', Rule::in(Pangkat::values())],
            'golongan' => ['nullable', 'string', Rule::in(Golongan::values())],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'sub_seksi' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Kita modifikasi validation rule untuk email agar mengecualikan user_id yang sedang diedit.
     */
    protected function prepareForValidation()
    {
        // Pastikan kita tidak menambah data apapun, ini hanya hook
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         // Cek unique email manual untuk user_id yang dikirim
    //         $existing = \App\Models\User::where('email', $this->email)
    //             ->where('id', '!=', $this->user_id)
    //             ->first();
    //
    //         if ($existing) {
    //             $validator->errors()->add('email', 'Email sudah digunakan oleh pengguna lain.');
    //         }
    //     });
    // }
}
