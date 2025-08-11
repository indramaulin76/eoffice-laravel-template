<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiLaporanPerjalananDinas extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_laporan_perjalanan_dinas';

    protected $guarded = ['id'];
}
