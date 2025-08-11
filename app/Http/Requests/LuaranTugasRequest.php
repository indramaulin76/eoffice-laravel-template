<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LuaranTugasRequest extends FormRequest
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
            'judul' => ['required', 'string'],
            'uraian' => ['required', 'string'],
            'keterangan' => ['required', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx'],
        ];
    }
}
