<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_abk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uraian_tugas_id')->constrained('uraian_tugas');
            $table->integer('waktu_penyelesaian');
            $table->string('hasil_kerja');
            $table->integer('jumlah_hasil_kerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_abk');
    }
};
