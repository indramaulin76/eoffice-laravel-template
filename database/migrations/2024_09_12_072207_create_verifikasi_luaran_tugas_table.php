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
        Schema::create('verifikasi_luaran_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('luaran_tugas_id');
            $table->foreignId('verifikatur_id')->constrained('user');
            $table->enum('status', ['disetujui', 'ditolak']);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('luaran_tugas_id')->references('id')->on('luaran_tugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_luaran_tugas');
    }
};
