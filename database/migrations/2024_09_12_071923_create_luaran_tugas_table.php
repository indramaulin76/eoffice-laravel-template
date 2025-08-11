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
        Schema::create('luaran_tugas', function (Blueprint $table) {
            $table->string('id')->primary(); // Set id sebagai primary key
            $table->foreignId('pegawai_id')->constrained('user');
            $table->string('uraian_tugas');
            $table->integer('bobot');
            $table->integer('target');
            $table->string('judul');
            $table->string('keterangan');
            $table->string('file_luaran');
            $table->dateTime('waktu_pengumpulan');
            $table->enum('status', ['sedang diperiksa', 'disetujui', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luaran_tugas');
    }
};
