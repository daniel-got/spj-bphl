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
            'rincian_biaya'                   => 'required|array|min:1',
            'rincian_biaya.*.biaya_transport'  => 'nullable|numeric|min:0',
            'rincian_biaya.*.penginapan'       => 'nullable|integer|in:30,100',
            'rincian_biaya.*.hotel_ril'        => 'nullable|numeric|min:0',
            'status'                           => 'nullable|in:draft,diajukan,direvisi,disetujui,ditolak',
        ];
    }
}
