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
        Schema::create('verifikasi_surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('surat_keluar_id');
            $table->foreignId('verifikatur_id')->constrained('user');
            $table->enum('status', ['Disetujui', 'Ditolak']);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('surat_keluar_id')->references('id')->on('surat_keluar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_surat_keluar');
    }
};
