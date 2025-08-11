<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\SuratKeluar;
use App\Models\VerifikasiSuratKeluar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Generate 10 fake data
        SuratKeluar::factory(100)->create()->each(function ($suratKeluar) {
            if ($suratKeluar->status != 'Dalam Proses') {
                $suratKeluar->verifikasi()->save(VerifikasiSuratKeluar::factory([
                    'status' => $suratKeluar->status
                ])->make());
            }

            if ($suratKeluar->status == 'Disetujui') {
                Log::create([
                    'pegawai_id' => $suratKeluar->penulis_id,
                    'kegiatan_id' => $suratKeluar->id,
                    'bobot' => 5,
                ]);
            }
        });

    }
}
