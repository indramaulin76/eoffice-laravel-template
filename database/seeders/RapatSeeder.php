<?php

namespace Database\Seeders;

use App\Models\Log;
use Illuminate\Database\Seeder;
use App\Models\Rapat;
use App\Models\PresensiRapat;
use App\Models\User;

class RapatSeeder extends Seeder
{
    public function run()
    {
        // Loop untuk membuat 5 rapat secara manual
        for ($i = 1; $i <= 5; $i++) {
            // Generate custom ID
            $todayPrefix = 'R' . now()->format('ymd');
            $lastNumber = Rapat::where('id', 'like', "{$todayPrefix}%")->count() + 1;
            $customId = "{$todayPrefix}{$lastNumber}";

            // Buat waktu mulai dan waktu selesai
            $waktuMulai = now()->addDays(rand(1, 30)); // Buat rapat di masa depan
            $durasiRapat = rand(1, 3); // Durasi rapat antara 1-3 jam
            $waktuSelesai = (clone $waktuMulai)->addHours($durasiRapat); // Tambah durasi rapat



            // Pilih pemimpin rapat secara acak
            $pemimpinRapat = User::inRandomOrder()->first();

            // Simpan rapat ke database
            $rapat = Rapat::create([
                'id' => $customId,
                'pemimpin_rapat_id' => $pemimpinRapat->id,
                'judul' => fake()->sentence(),
                'perihal' => fake()->paragraph(),
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
                'tempat' => fake()->randomElement(['Ruang Rapat A', 'Ruang Rapat B', 'Aula Utama', 'Ruang Konferensi']),
                'warna_label' => fake()->randomElement(['#d50000', '#039ae5', '#33b679']),
            ]);

            // Memastikan pemimpin rapat juga terdaftar sebagai peserta
            PresensiRapat::create([
                'rapat_id' => $rapat->id,
                'pegawai_id' => $pemimpinRapat->id,
                'status' => 'hadir',
            ]);

            // Menambahkan 4-9 peserta tambahan
            $jumlahPesertaTambahan = rand(4, 9);
            $pesertaIds = User::where('id', '!=', $pemimpinRapat->id)
                ->inRandomOrder()
                ->limit($jumlahPesertaTambahan)
                ->pluck('id');

            foreach ($pesertaIds as $pesertaId) {
                $presensi = PresensiRapat::create([
                    'rapat_id' => $rapat->id,
                    'pegawai_id' => $pesertaId,
                    'status' => fake()->randomElement(['hadir', 'izin', 'notset']),
                ]);

                if ($presensi->status === 'hadir') {
                    Log::create([
                        'pegawai_id' => $pesertaId,
                        'kegiatan_id' => $rapat->id,
                        'bobot' => $durasiRapat * 60, // 1 jam = 60 menit
                    ]);
                }
            }
        }
    }
}
