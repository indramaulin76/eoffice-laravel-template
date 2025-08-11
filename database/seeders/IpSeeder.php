<?php

namespace Database\Seeders;

use App\Models\IpLogin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create IP 127.0.0.1
        IpLogin::create([
            'alamat_ip' => '127.0.0.1'
        ]);
    }
}
