<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use App\Models\UserTutam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $sekretaris = Role::firstOrCreate(['name' => 'Sekretaris']);
        $pengelolaKeuangan = Role::firstOrCreate(['name' => 'Pengelola Keuangan']);
        $pengadministrasiPersuratan = Role::firstOrCreate(['name' => 'Pengadministrasi Persuratan']);

        // create permissions
        $permissionRevisi = Permission::firstOrCreate(['name' => 'revisi']);
        $permissionBuatRapat = Permission::firstOrCreate(['name' => 'buat rapat']);
        $permissionBuatSppd = Permission::firstOrCreate(['name' => 'buat sppd']);
        $permissionBuatSurat = Permission::firstOrCreate(['name' => 'buat surat']);
        $permissionLihatSurat = Permission::firstOrCreate(['name' => 'lihat surat']);
        $permissionBuatArsipSurat = Permission::firstOrCreate(['name' => 'buat arsip surat']);

        // assign permissions to roles
        $supervisor->givePermissionTo([$permissionRevisi, $permissionLihatSurat]);
        $sekretaris->givePermissionTo($permissionBuatRapat);
        $pengelolaKeuangan->givePermissionTo($permissionBuatSppd);
        $pengadministrasiPersuratan->givePermissionTo([$permissionBuatSurat, $permissionLihatSurat, $permissionBuatArsipSurat]);

        User::create([
            'unit_kerja_id' => 1,
            'jabatan_id' => 13,
            'nama' => 'Supervisor Akademik dan Kemahasiswaan',
            'email' => 'supervisorak@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($supervisor);

        UserTutam::create([
            'user_id' => 1,
            'tutam_id' => 6,
        ]);

        User::create([
            'unit_kerja_id' => 1,
            'jabatan_id' => 14,
            'nama' => 'Supervisor Sumberdaya',
            'email' => 'supervisorsdm@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($supervisor);

        UserTutam::create([
            'user_id' => 2,
            'tutam_id' => 7,
        ]);

        $data = json_decode(file_get_contents(database_path('seeders/data/user.json')), true);

        $userCount = 1;
        foreach ($data as $user) {
            $user = User::create([
                'unit_kerja_id' => $user['unit_kerja_id'],
                'jabatan_id' => $user['jabatan_id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'supervisor_id' => $user['supervisor_id'],
                'password' => bcrypt($user['password']),
            ]);

            for ($i = 1; $i <= 6; $i++) {
                Log::create([
                    'pegawai_id' => $user->id,
                    'kegiatan_id' => 'P'.'24100'.$i.$userCount,
                    'bobot' => 450,
                ]);
            }

            // for ($i = 1; $i <= 2; $i++) {
            //     Log::create([
            //         'pegawai_id' => $user->id,
            //         'kegiatan_id' => 'R'.'24100'.$i.$userCount,
            //         'bobot' => 100,
            //     ]);
            // }

            $userCount += 1;
        }

        User::create([
            'unit_kerja_id' => 2,
            'jabatan_id' => 1,
            'nama' => 'Sekretaris',
            'email' => 'sekretaris@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($sekretaris);

        User::create([
            'unit_kerja_id' => 2,
            'jabatan_id' => 2,
            'nama' => 'Pengelola Keuangan',
            'email' => 'pengelolakeuangan@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($pengelolaKeuangan);

        User::create([
            'unit_kerja_id' => 2,
            'jabatan_id' => 3,
            'nama' => 'Pengadministrasi Persuratan',
            'email' => 'pengadministrasipersuratan@gmail.com',
            'password' => bcrypt('password'),
        ])->assignRole($pengadministrasiPersuratan);
    }
}
