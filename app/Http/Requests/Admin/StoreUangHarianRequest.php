<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUangHarianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provinsi' => 'required|string|max:255|unique:data_uang_harian,provinsi',
            'luar_kota' => 'required|integer|min:0',
            'dalam_kota_lebih_8_jam' => 'required|integer|min:0',
            'diklat' => 'required|integer|min:0',
        ];
    }
}
