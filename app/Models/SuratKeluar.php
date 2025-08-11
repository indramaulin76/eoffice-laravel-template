<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $guarded = ['id'];

    protected $primaryKey = 'id'; // Set primary key

    public $incrementing = false; // Set primary key as string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Dapatkan tanggal hari ini dalam format yy-mm-dd
            $date = now()->format('ymd');

            // Buat prefix ID untuk hari ini
            $todayPrefix = 'K' . $date;

            // Hitung jumlah entri dengan prefix yang sama
            $lastNumber = self::where('id', 'like', "{$todayPrefix}%")->count() + 1;

            // Generate ID baru
            $model->id = "{$todayPrefix}{$lastNumber}";
        });
    }

    public function tanggalDibuat()
    {
        return $this->created_at->translatedFormat('l, j F Y');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function penandatangan()
    {
        return $this->belongsTo(User::class, 'penandatangan_id');
    }

    public function alasanPenolakan() {
        return $this->hasOne(VerifikasiSuratKeluar::class, 'surat_keluar_id')->where('status', 'Ditolak')->latest()->first()->catatan;
    }

    public function verifikasi() {
        return $this->hasOne(VerifikasiSuratKeluar::class, 'surat_keluar_id');
    }
}
