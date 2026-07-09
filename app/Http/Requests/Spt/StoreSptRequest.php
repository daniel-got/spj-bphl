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
            'pegawai_ditugaskan.*.peran' => 'required|string|in:Penanggung Jawab,Anggota',

            'tujuan_kegiatan' => 'required|string',
            'tempat_tujuan' => 'required|string|max:255',
            'tgl_berangkat' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_berangkat',
            'lama_kegiatan' => 'required|integer|min:1',
            'kode_mak' => 'required|string|max:255',
        ];
    }
}
