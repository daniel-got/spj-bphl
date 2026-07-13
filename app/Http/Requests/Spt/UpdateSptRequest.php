<?php

namespace App\Http\Requests\Spt;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSptRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $spt = $this->route('spt');
        $sptId = is_object($spt) ? $spt->id : $spt;

        return [
            'nomor_spt' => 'required|string|unique:data_spt,nomor_spt,'.$sptId,
            'status' => 'nullable|string|in:draft,diajukan,direvisi,disetujui,ditolak',
            'tgl_spt' => 'required|date',
            'pegawai_ditugaskan' => 'required|string',

            // Tambahan validasi Kategori dan Surat Dasar Baru
            'jenis_tugas' => 'required|in:pelatihan,keuangan,administrasi',
            'surat_dasar' => 'nullable|string',

            // Tambahan validasi untuk Penanggung Jawab dan Anggota (Instruksi Rifka No. 2)
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