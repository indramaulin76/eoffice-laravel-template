<?php

namespace Database\Factories;

use App\Models\LaporanPerjalananDinas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerifikasiLaporanPerjalananDinas>
 */
class VerifikasiLaporanPerjalananDinasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'laporan_id' => LaporanPerjalananDinas::inRandomOrder()->first()->id,
            'verifikatur_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Disetujui', 'Ditolak']),
            'catatan' => $this->faker->sentence,
        ];
    }
}
