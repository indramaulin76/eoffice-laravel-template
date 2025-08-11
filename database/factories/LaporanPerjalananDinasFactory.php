<?php

namespace Database\Factories;

use App\Models\PerjalananDinas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaporanPerjalananDinas>
 */
class LaporanPerjalananDinasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pegawai_id' => User::inRandomOrder()->first()->id,
            'perjalanan_dinas_id' => PerjalananDinas::inRandomOrder()->first()->id,
            'file_laporan' => $this->faker->word,
            'keterangan' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['Disetujui', 'Dalam Proses', 'Ditolak']),
            'waktu_pengumpulan' => $this->faker->date(),
        ];
    }
}
