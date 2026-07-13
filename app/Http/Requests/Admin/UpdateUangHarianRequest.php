<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUangHarianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $id = $this->route('uangHarian')->id ?? $this->route('uang_harian')->id;

        return [
            'provinsi' => 'required|string|max:255|unique:data_uang_harian,provinsi,'.$id,
            'luar_kota' => 'required|integer|min:0',
            'dalam_kota_lebih_8_jam' => 'required|integer|min:0',
            'diklat' => 'required|integer|min:0',
        ];
    }
}
