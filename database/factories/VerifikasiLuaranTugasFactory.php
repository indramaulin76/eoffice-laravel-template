<?php

namespace Database\Factories;

use App\Models\LuaranTugas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerifikasiLuaranTugas>
 */
class VerifikasiLuaranTugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['disetujui', 'ditolak']);

        return [
            'luaran_tugas_id' => LuaranTugas::inRandomOrder()->first()->id,
            'verifikatur_id' => User::where('nama','Supervisor Sumberdaya')->orWhere('nama','Supervisor Akademik dan Kemahasiswaan')->inRandomOrder()->first()->id,
            'status' => $status,
            'catatan' => $this->faker->sentence,
        ];
    }
}
