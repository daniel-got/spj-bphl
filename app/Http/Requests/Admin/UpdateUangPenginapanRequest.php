<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUangPenginapanRequest extends FormRequest
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
        // Assuming the route parameter is named 'uangPenginapan' or 'uang_penginapan'
        $id = $this->route('uangPenginapan')?->id ?? $this->route('uang_penginapan')?->id;

        return [
            'provinsi' => 'required|string|max:255|unique:data_uang_penginapan,provinsi,'.$id,
            'gol_iv' => 'required|integer|min:0',
            'gol_iii_ii_i' => 'required|integer|min:0',
        ];
    }
}
