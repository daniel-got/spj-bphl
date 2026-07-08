<?php

namespace App\Http\Requests\Spd;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpdRequest extends FormRequest
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
        return [
            'nomor_spd' => 'required|string|unique:data_spd,nomor_spd',
            'status' => 'nullable|string|in:draft,diajukan,direvisi,disetujui,ditolak',
            'alasan' => 'nullable|string',
            'tgl_spd' => 'required|date',
            'nip_pegawai' => 'required|string|max:50',
            'berangkat_dari' => 'required|string|max:255',
            'alat_angkut' => 'required|array|min:1',
            'alat_angkut.*' => 'required|string|max:255',
            'ppk' => 'required|string|in:Pejabat Pembuat Komitmen 1,Pejabat Pembuat Komitmen 2,Pejabat Pembuat Komitmen 3,Bendahara Pengeluaran',
            'nama_ppk' => 'required|string|max:255',
            'nip_ppk' => 'required|string|max:50',
            'spt_id' => 'required|exists:data_spt,id',
        ];
    }
}
