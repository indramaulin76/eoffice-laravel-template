<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_surat_keluar';

    protected $guarded = ['id'];
}
