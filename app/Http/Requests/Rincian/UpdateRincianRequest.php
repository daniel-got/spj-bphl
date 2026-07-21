<?php

namespace App\Http\Requests\Rincian;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRincianRequest extends FormRequest
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
            'rincian_biaya' => 'required|array',
            'rincian_biaya.transport' => 'nullable|array',
            'rincian_biaya.penginapan' => 'nullable|array',

            // Validasi field dalam rincian biaya transport
            'rincian_biaya.transport.*.*.lokasi_awal' => 'nullable|string',
            'rincian_biaya.transport.*.*.lokasi_tujuan' => 'nullable|string',
            'rincian_biaya.transport.*.*.biaya' => 'nullable|numeric',
            'rincian_biaya.transport.*.*.lampiran' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',

            // Validasi field dalam rincian biaya penginapan
            'rincian_biaya.penginapan.*.keterangan' => 'nullable|string',
            'rincian_biaya.penginapan.*.penginapan_persen' => 'nullable|numeric',
            'rincian_biaya.penginapan.*.hotel_ril' => 'nullable|numeric',
            'rincian_biaya.penginapan.*.lampiran' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',

            'status' => 'nullable|in:draft,diajukan,direvisi,disetujui,ditolak',
        ];
    }
}
