<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiLuaranTugas extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_luaran_tugas';

    protected $guarded = ['id'];
}
