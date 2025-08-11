<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratMasuk>
 */
class SuratMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::whereHas('jabatan', function ($query) {
            $query->where('nama', 'Pengelola Informasi Akademik')->orWhere('nama','Pengadministrasi Akademik')->orWhere('nama','Pengadministrasi Persuratan')->orWhere('nama','Sekretaris');
        })->inRandomOrder()->first()->id;

        return [
            'nomor_surat' => $this->faker->unique()->numerify('###/###/###'),
            'perihal' => $this->faker->sentence,
            'asal' => $this->faker->name(),
            'tujuan' => $this->faker->name(),
            'tanggal_diterima' => $this->faker->date(),
            'file_surat' => $this->faker->word,
            'pengarsip_id' => $userId,
        ];
    }
}
