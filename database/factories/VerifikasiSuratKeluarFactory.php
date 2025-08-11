<?php

namespace Database\Factories;

use App\Models\SuratKeluar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerifikasiSuratKeluar>
 */
class VerifikasiSuratKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['Disetujui', 'Ditolak']);

        return [
            'surat_keluar_id' => SuratKeluar::inRandomOrder()->first()->id,
            'verifikatur_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Disetujui', 'Ditolak']),
            'catatan' => $this->faker->sentence,
        ];
    }
}
