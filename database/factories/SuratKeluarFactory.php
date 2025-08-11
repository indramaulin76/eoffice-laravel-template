<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratKeluar>
 */
class SuratKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penulis_id' => 1,
            'perihal' => $this->faker->sentence,
            'nomor_surat' => 'SK-' . time(),
            'asal' => $this->faker->name(),
            'tujuan' => $this->faker->name(),
            'alamat_surat' => $this->faker->address,
            'penandatangan_id' => 2,
            'file_surat' => $this->faker->word,
            'file_arsip' => null,
            'tanggal_dikirim' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Disetujui', 'Dalam Proses', 'Ditolak']),
        ];
    }
}
