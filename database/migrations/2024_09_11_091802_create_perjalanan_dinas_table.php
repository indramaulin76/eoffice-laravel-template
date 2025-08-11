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
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->string('id')->primary(); // Set id sebagai primary key
            $table->foreignId('pemberi_perintah_id')->constrained('user');
            $table->foreignId('jabatan_pemberi_perintah_id')->constrained('jabatan');
            $table->foreignId('pelaksana_id')->constrained('user');
            $table->foreignId('jabatan_pelaksana_id')->constrained('jabatan');
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->string('keperluan_perjalanan');
            $table->string('alamat_perjalanan');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->unsignedBigInteger('anggaran');
            $table->string('keterangan');
            $table->string('file_sppd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perjalanan_dinas');
    }
};
