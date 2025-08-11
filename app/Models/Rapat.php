<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rapat extends Model
{
    use HasFactory;

    protected $table = 'rapat';

    public $incrementing = false;

    protected $guarded = [];

    protected $primaryKey = 'id'; // Set primary key

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Dapatkan tanggal hari ini dalam format yy-mm-dd
            $date = now()->format('ymd');

            // Buat prefix ID untuk hari ini
            $todayPrefix = 'R' . $date;

            // Hitung jumlah entri dengan prefix yang sama
            $lastNumber = self::where('id', 'like', "{$todayPrefix}%")->count() + 1;

            // Generate ID baru
            $model->id = "{$todayPrefix}{$lastNumber}";
        });
    }

    // Relationship ke model PresensiRapat
    public function presensiRapat()
    {
        return $this->hasMany(PresensiRapat::class);
    }

    public function pemimpinRapat()
    {
        return User::find($this->pemimpin_rapat_id);
    }

    public function tanggal()
    {
        return Carbon::parse($this->waktu_mulai)->toDateString(); // Mengembalikan format YYYY-MM-DD
    }

    // Method untuk format tanggal
    public function hariTanggal()
    {
        return Carbon::parse($this->start_time)->translatedFormat('l, j F Y');
    }

    // Method untuk format waktu mulai
    public function waktuMulai()
    {
        return Carbon::parse($this->waktu_mulai)->format('H:i');
    }

    // Method untuk format waktu selesai
    public function waktuSelesai()
    {
        return Carbon::parse($this->waktu_selesai)->format('H:i');
    }

    // Method untuk mengambil status kehadiran user yang sedang login
    public function attendanceOfLoggedInUser()
    {
        // Ambil user yang login
        $loggedInUserId = Auth::id();

        // Cari data presensi rapat yang sesuai dengan user yang login
        $presensi = $this->presensiRapat()->where('pegawai_id', $loggedInUserId)->first();

        // Kalau ada presensi, return statusnya, kalau nggak ada return 'Belum hadir'
        return $presensi->status;
    }

    // Method untuk mengambil semua peserta rapat
    public function pesertaRapat()
    {
        return $this->presensiRapat->map(function ($presensi) {
            return $presensi->pegawai;
        });
    }

    public static function hitungTotalDurasi($rapats)
    {
        // Hitung total durasi dalam menit
        $totalDurasi = $rapats->sum(function ($rapat) {
            $waktuMulai = Carbon::parse($rapat->waktu_mulai);
            $waktuSelesai = Carbon::parse($rapat->waktu_selesai);

            // Hitung selisih dalam satuan menit
            return $waktuSelesai->diffInMinutes($waktuMulai);
        });

        return $totalDurasi*-1;
    }
}
