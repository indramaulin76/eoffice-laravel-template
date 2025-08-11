<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPerjalananDinas extends Model
{
    use HasFactory;

    protected $table = 'laporan_perjalanan_dinas';

    protected $guarded = ['id'];

    public function alasanPenolakan()
    {
        return $this->hasOne(VerifikasiLaporanPerjalananDinas::class, 'laporan_id')->where('status','Ditolak')->pluck('catatan');
    }
    public function perjalananDinas()
    {
        return $this->belongsTo(PerjalananDinas::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiLaporanPerjalananDinas::class, 'laporan_id');
    }
}
