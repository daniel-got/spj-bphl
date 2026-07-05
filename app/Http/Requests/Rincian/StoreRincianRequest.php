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
            'spd_id' => 'required|exists:data_spd,id',
            'biaya_transport' => 'nullable|numeric|min:0',
            'penginapan' => 'nullable|integer|min:0|max:100',
            'hotel_ril' => 'nullable|numeric|min:0',
            'detail_transportasi' => 'nullable|array',
        ];
    }
}
