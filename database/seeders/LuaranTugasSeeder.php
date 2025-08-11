<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\LuaranTugas;
use App\Models\User;
use App\Models\VerifikasiLuaranTugas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LuaranTugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get all users except Supervisor Akademik dan Kemahasiswaan and Supervisor Sumberdaya
        $users = User::whereNot(function ($query) {
            $query->where('nama', "Supervisor Akademik dan Kemahasiswaan")
                ->orWhere('nama', "Supervisor Sumberdaya");
        })->get();

        // for each user get uraian tugas by jabatan and supervisor
        foreach ($users as $user) {

            if ($user->supervisor == null) {
                continue;

            }
            $response = Http::get('http://anjab-abk.test/api/uraian-tugas-by-jabatan-and-supervisor', 
            [
                'jabatan_id' => $user->jabatan_id,
                'supervisor_id' => $user->supervisor->userTutam->tutam_id,
            ]);

            $detailAbk = $response->json()['data'];

            foreach ($detailAbk as $uraianTugas) {
                LuaranTugas::factory()->count(rand(1, 5))->create([
                    'pegawai_id' => $user->id,
                    'uraian_tugas' => $uraianTugas['nama_tugas'],
                    'judul' => $uraianTugas['nama_tugas'],
                    'bobot' => $uraianTugas['bobot'],
                    'target' => $uraianTugas['target']
                ])->each(function ($luaranTugas) {
                    if ($luaranTugas->status != 'sedang diperiksa') {
                        $luaranTugas->verifikasi()->save(VerifikasiLuaranTugas::factory([
                            'status' => $luaranTugas->status
                        ])->make());
                    }

                    if ($luaranTugas->status == 'disetujui') {
                        Log::create([
                            'pegawai_id' => $luaranTugas->pegawai_id,
                            'kegiatan_id' => $luaranTugas->id,
                            'bobot' => $luaranTugas->bobot,
                        ]);
                    }
                });
            }
        }
    }
}
