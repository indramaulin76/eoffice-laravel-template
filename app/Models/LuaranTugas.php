<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuaranTugas extends Model
{
    use HasFactory;

    protected $table = 'luaran_tugas';

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
            $todayPrefix = 'L' . $date;

            // Hitung jumlah entri dengan prefix yang sama
            $lastNumber = self::where('id', 'like', "{$todayPrefix}%")->count() + 1;

            // Generate ID baru
            $model->id = "{$todayPrefix}{$lastNumber}";
        });
    }

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function detailAbk()
    {
        return $this->belongsTo(DetailAbk::class);
    }

    public function alasanPenolakan()
    {
        return $this->hasOne(VerifikasiLuaranTugas::class, 'luaran_tugas_id')->where('status', 'ditolak')->pluck('catatan');
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiLuaranTugas::class, 'luaran_tugas_id');
    }
}
