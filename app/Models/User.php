<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function presensiHarian()
    {
        return $this->hasMany(PresensiHarian::class);
    }

    public function unitKerja() {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function supervisor() {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function userTutam() {
        return $this->hasOne(UserTutam::class);
    }

    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function luaranTugas() {
        return $this->hasMany(LuaranTugas::class, 'pegawai_id');
    }

    public function bawahan() {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function luaranTugasBawahan() {
        return $this->hasManyThrough(LuaranTugas::class, User::class, 'supervisor_id', 'pegawai_id');
    }

    public function perjalananDinas() {
        return $this->hasMany(PerjalananDinas::class, 'pelaksana_id');
    }
}
