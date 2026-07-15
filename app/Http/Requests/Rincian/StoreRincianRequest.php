<?php

namespace App\Http\Requests\Rincian;

use Illuminate\Foundation\Http\FormRequest;

class StoreRincianRequest extends FormRequest
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
            'spd_id' => 'required|exists:data_spd,id|unique:data_rincian,spd_id',
            'rincian_biaya' => 'required|array|min:1',
            // Kunci mengikuti skema form & tampilan: biaya_transport, penginapan (%), hotel_ril.
            'rincian_biaya.*.biaya_transport' => 'required|numeric|min:0',
            'rincian_biaya.*.penginapan' => 'nullable|numeric|min:0',
            'rincian_biaya.*.hotel_ril' => 'nullable|numeric|min:0',
            'lampiran' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB PDF
        ];
    }
}
