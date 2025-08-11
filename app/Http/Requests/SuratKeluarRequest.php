<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratKeluarRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'perihal' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'alamat' => 'required',
            'penandatangan_id' => 'required',
            'file_surat' => ['file', 'mimes:pdf',],
            'body' => 'required_if:file_surat,null',
            'tanggal_surat' => 'required',
        ];
    }
}
