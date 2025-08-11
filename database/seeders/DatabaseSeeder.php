<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UnitKerjaSeeder::class,
            JabatanSeeder::class,
            UserSeeder::class,
            IpSeeder::class,
            RapatSeeder::class,
            SuratKeluarSeeder::class,
            SuratMasukSeeder::class,
            LuaranTugasSeeder::class,
            PerjalananDinasSeeder::class,
            // UserSeeder::class,
        ]);
    }
}
