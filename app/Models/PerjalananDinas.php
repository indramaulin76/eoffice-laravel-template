<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class PerjalananDinas extends Model
{
    use HasFactory;

    protected $table = 'perjalanan_dinas';

    protected $guarded = ['id'];

    protected $primaryKey = 'id'; // Set primary key

    public $incrementing = false;   

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            // Dapatkan tanggal hari ini dalam format yy-mm-dd
            $date = now()->format('ymd');

            // Buat prefix ID untuk hari ini
            $todayPrefix = 'D' . $date;

            // Hitung jumlah entri dengan prefix yang sama
            $lastNumber = self::where('id', 'like', "{$todayPrefix}%")->count() + 1;

            // Generate ID baru
            $model->id = "{$todayPrefix}{$lastNumber}";
        });
    }

    public function pemberiPerintah()
    {
        return $this->belongsTo(User::class, 'pemberi_perintah_id');
    }

    public function pelaksana()
    {
        return $this->belongsTo(User::class, 'pelaksana_id');
    }

    public function tanggalMulai()
    {
        return Carbon::parse($this->tanggal_mulai)->translatedFormat('l, j F Y');
    }
    public function tanggalSelesai()
    {
        return Carbon::parse($this->tanggal_selesai)->translatedFormat('l, j F Y');
    }

    public function anggaran()
    {
        // return Number::currency($this->anggaran, 'IDR');
        return 'Rp ' . number_format($this->anggaran, 0, ',', '.');
    }

    public function laporanPerjalananDinas()
    {
        return $this->hasOne(LaporanPerjalananDinas::class, 'perjalanan_dinas_id');
    }
}
