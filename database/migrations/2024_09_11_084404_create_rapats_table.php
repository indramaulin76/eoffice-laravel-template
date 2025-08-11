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
        Schema::create('rapat', function (Blueprint $table) {
            $table->string('id')->primary(); // Set id sebagai primary key
            $table->foreignId('pemimpin_rapat_id')->constrained('user');
            $table->string('judul');
            $table->text('perihal');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('tempat');
            $table->string('warna_label')->default('#039ae5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapat');
    }
};
