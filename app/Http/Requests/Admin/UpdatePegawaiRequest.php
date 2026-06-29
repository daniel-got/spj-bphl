<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        // Mendapatkan ID pegawai dari parameter route 'pegawai'
        // Jika route berupa resource: Route::resource('pegawai', KelolaPegawaiController::class)
        $pegawaiId = $this->route('pegawai');

        return [
            'nama_pegawai'     => ['required', 'string', 'max:255'],
            'nip'              => ['required', 'string', 'max:50', "unique:data_pegawai,nip,{$pegawaiId}"],
            // Untuk email, kita perlu ID User dari pegawai ini, karena unique:users mengecek id user.
            // Bisa menggunakan Rule::unique('users', 'email')->ignore() di controller atau service
            // Namun, untuk memudahkan, kita pakai rule di sini. 
            // Nanti di Service kita yang cari user-nya. Di Request ini kita biarkan tanpa ignore dulu
            // TAPI, wait, kalau email sama persis, validasi unique akan gagal. Kita butuh ID user.
            // Cara termudahnya, kita taruh validasi unique di Service, ATAU tambahkan hidden input user_id di form.
            // Karena ini FormRequest, kita bisa cari Pegawai dulu.
            'user_id'          => ['required', 'exists:users,id'],
            'email'            => ['required', 'string', 'email', 'max:255'], // unique check akan di tambahkan di controller/service jika berubah
            'password'         => ['nullable', 'string', 'min:8'], // Opsional saat update
            'role'             => ['required', 'string', \Illuminate\Validation\Rule::in(\App\Enums\UserRole::values())],
            'pangkat_golongan' => ['nullable', 'string', 'max:100'],
            'jabatan'          => ['nullable', 'string', 'max:100'],
            'sub_seksi'        => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Kita modifikasi validation rule untuk email agar mengecualikan user_id yang sedang diedit.
     */
    protected function prepareForValidation()
    {
        // Pastikan kita tidak menambah data apapun, ini hanya hook
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Cek unique email manual untuk user_id yang dikirim
            $existing = \App\Models\User::where('email', $this->email)
                ->where('id', '!=', $this->user_id)
                ->first();
                
            if ($existing) {
                $validator->errors()->add('email', 'Email sudah digunakan oleh pengguna lain.');
            }
        });
    }
}
