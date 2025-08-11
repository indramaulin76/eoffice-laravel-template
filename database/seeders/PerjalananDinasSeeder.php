<?php

namespace Database\Seeders;

use App\Models\LaporanPerjalananDinas;
use App\Models\Log;
use App\Models\PerjalananDinas;
use App\Models\VerifikasiLaporanPerjalananDinas;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerjalananDinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerjalananDinas::factory()
            ->count(100)
            ->create()->each(function ($perjalananDinas) {{
                    $laporan = $perjalananDinas->laporanPerjalananDinas()->save(LaporanPerjalananDinas::factory([
                        'perjalanan_dinas_id' => $perjalananDinas->id,
                        'status' => fake()->randomElement(['Disetujui', 'Dalam Proses', 'Ditolak'])
                    ])->make());

                    if ($laporan->status != 'Dalam Proses') {
                        $laporan->verifikasi()->save(VerifikasiLaporanPerjalananDinas::factory([
                            'status' => $laporan->status
                        ])->make());
                    }

                    if ($laporan->status == 'Disetujui') {
                        $waktuMulai = Carbon::parse($perjalananDinas->tanggal_mulai);
                        $waktuSelesai = Carbon::parse($perjalananDinas->tanggal_selesai);
                        $bobot = $waktuMulai->diffInMinutes($waktuSelesai);
                        Log::create([
                            'pegawai_id' => $laporan->pegawai_id,
                            'kegiatan_id' => $perjalananDinas->id,
                            'bobot' => $bobot,
                        ]);
                    }
                }
            });
    }
}
