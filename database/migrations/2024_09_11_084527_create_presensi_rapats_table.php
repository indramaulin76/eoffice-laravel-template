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
        Schema::create('presensi_rapat', function (Blueprint $table) {
            $table->id();
            $table->string('rapat_id');
            $table->foreignId('pegawai_id')->constrained('user');
            $table->enum('status', ['hadir', 'izin', 'notset'])->default('notset');
            $table->timestamps();

            $table->foreign('rapat_id')->references('id')->on('rapat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_rapat');
    }
};
