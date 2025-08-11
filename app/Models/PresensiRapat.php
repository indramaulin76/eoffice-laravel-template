<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiRapat extends Model
{
    use HasFactory;

    protected $table = 'presensi_rapat';

    protected $guarded = ['id'];

    // Relationship ke model Rapat
    public function rapat()
    {
        return $this->belongsTo(Rapat::class);
    }

    // Relationship ke model User
    public function pegawai()
    {
        return $this->belongsTo(User::class);
    }
}
