<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\SuratMasuk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuratMasuk::factory()
            ->count(100)
            ->create()->each(function ($surat) {
                Log::create([
                    'pegawai_id' => $surat->pengarsip_id,
                    'kegiatan_id' => $surat->id,
                    'bobot' => 5,
                ]);
            });
    }
}
