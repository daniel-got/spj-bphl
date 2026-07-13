<?php

namespace App\Http\Requests\Spt;

use Illuminate\Foundation\Http\FormRequest;

class StoreSptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (is_string($this->pegawai_ditugaskan)) {
            $this->merge([
                'pegawai_ditugaskan' => json_decode($this->pegawai_ditugaskan, true),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nomor_spt' => 'required|string|unique:data_spt,nomor_spt',
            'status' => 'nullable|string|in:draft,diajukan,direvisi,disetujui,ditolak',
            'tgl_spt' => 'required|date',
            'pegawai_ditugaskan' => 'required|array|min:1',
            'pegawai_ditugaskan.*.pegawai_id' => 'required|exists:data_pegawai,id',
            'pegawai_ditugaskan.*.nama_pegawai' => 'required|string',
            'pegawai_ditugaskan.*.nip' => 'required|string',
            'pegawai_ditugaskan.*.pangkat' => 'required|string',
            'pegawai_ditugaskan.*.jabatan' => 'required|string',
            'pegawai_ditugaskan.*.peran' => 'required|string|in:Penanggung Jawab,Anggota',

            // Tambahan validasi Kategori dan Surat Dasar Baru
            'jenis_tugas' => 'required|in:pelatihan,keuangan,administrasi',
            'surat_dasar' => 'nullable|string',

            // Tambahan validasi untuk Penanggung Jawab dan Anggota
            'penanggung_jawab' => 'nullable|string',
            'anggota' => 'nullable|string',

            // Tambahan validasi untuk keperluan generate PDF Surat Tugas
            'menimbang' => 'nullable|string',
            'dasar' => 'nullable|string',
            'biaya' => 'nullable|string',

            'tujuan_kegiatan' => 'required|string',
            'tempat_tujuan' => 'required|string|max:255',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_berangkat',
            'lama_kegiatan' => 'required|integer|min:1',
            'kode_mak' => 'required|string|max:255',
        ];
    }
}
