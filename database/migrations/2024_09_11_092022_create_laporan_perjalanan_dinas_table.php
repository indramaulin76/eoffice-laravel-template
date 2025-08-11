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
        Schema::create('laporan_perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('user');
            $table->string('perjalanan_dinas_id');
            $table->string('file_laporan');
            $table->string('keterangan')->nullable();
            $table->dateTime('waktu_pengumpulan');
            $table->enum('status', ['Disetujui', 'Dalam Proses', 'Ditolak']);
            $table->timestamps();

            $table->foreign('perjalanan_dinas_id')->references('id')->on('perjalanan_dinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perjalanan_dinas');
    }
};
