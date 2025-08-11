<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SppdRequest extends FormRequest
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
            'pemberi_perintah_id' => ['required', 'exists:user,id','different:pelaksana_id'],
            'jabatan_pemberi_perintah_id' => ['required', 'exists:jabatan,id'],
            'jabatan_pemberi_perintah' => ['required'],
            'pelaksana_id' => ['required', 'exists:user,id','different:pemberi_perintah_id'],
            'jabatan_pelaksana_id' => ['required', 'exists:jabatan,id'],
            'jabatan_pelaksana' => ['required'],
            'tanggal_surat' => ['required', 'date'],
            'alamat_perjalanan' => ['required'],
            'keperluan_perjalanan' => ['required'],
            'tanggal_mulai' => ['required', 'date','before_or_equal:tanggal_selesai'],
            'tanggal_selesai' => ['required', 'date','after_or_equal:tanggal_mulai'],
            'anggaran' => ['required', 'numeric'],
            'keterangan' => ['required'],
        ];
    }
}
