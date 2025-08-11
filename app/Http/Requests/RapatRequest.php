<?php

namespace App\Http\Requests;

use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RapatRequest extends FormRequest
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
        $validationRules = [
            'judul' => 'required|string',
            'pemimpinRapat' => 'required|string',
            'perihal' => 'required|string',
            'waktuMulai' => 'required',
            'waktuSelesai' => 'required',
            'tempat' => 'required|string',
            'pesertaRapat' => 'required|array',
        ];
        // if request is from rapat.create, add 'tanggal' to the validation rules
        if (request()->has('tanggal')) {
            $validationRules['tanggal'] = 'required';
        }

        return $validationRules;
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                // Check if end time is after start time
                $waktuMulai = Carbon::parse($this->tanggal . ' ' .  $this->waktuMulai);
                $waktuSelesai = Carbon::parse($this->tanggal . ' ' . $this->waktuSelesai);

                // Check for schedule overlaps
                $query = Rapat::where('tempat', $this->tempat)->where(function ($query) use ($waktuMulai, $waktuSelesai) {
                    $query
                        ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                            // New meeting starts during an existing meeting
                            $q->where('waktu_mulai', '<=', $waktuMulai)->where('waktu_selesai', '>', $waktuMulai);
                        })
                        ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                            // New meeting ends during an existing meeting
                            $q->where('waktu_mulai', '<', $waktuSelesai)->where('waktu_selesai', '>=', $waktuSelesai);
                        })
                        ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                            // New meeting completely contains an existing meeting
                            $q->where('waktu_mulai', '>=', $waktuMulai)->where('waktu_selesai', '<=', $waktuSelesai);
                        });
                });

                // Exclude current record if updating
                if ($this->route('rapat')) {
                    $query->where('id', '!=', $this->route('rapat')->id);
                }

                if ($query->exists()) {
                    // dd('true');
                    $validator->errors()->add('tempat', 'Tempat sudah dibooking untuk waktu yang dipilih.');
                }
            },
        ];
    }
}
