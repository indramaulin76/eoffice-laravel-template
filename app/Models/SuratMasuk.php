<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

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
            $todayPrefix = 'M' . $date;

            // Hitung jumlah entri dengan prefix yang sama
            $lastNumber = self::where('id', 'like', "{$todayPrefix}%")->count() + 1;

            // Generate ID baru
            $model->id = "{$todayPrefix}{$lastNumber}";
        });
    }
  
    
    public function tanggalDiterima()
    {
        return Carbon::parse($this->created_at)->translatedFormat('l, j F Y');
    }
}
