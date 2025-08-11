<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LuaranTugas>
 */
class LuaranTugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $uraianTugas = $this->faker->sentence;

        return [
            'pegawai_id' => User::inRandomOrder()->first()->id,
            'judul' => $uraianTugas,
        'uraian_tugas' => $uraianTugas,
            'bobot' => $this->faker->randomNumber('3'),
            'target' => $this->faker->randomNumber('3'),
            'keterangan' => $this->faker->sentence,
            'file_luaran' => $this->faker->word,
            'waktu_pengumpulan' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement(['disetujui', 'sedang diperiksa', 'ditolak']),
        ];
    }
}
