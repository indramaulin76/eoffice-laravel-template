<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UraianTugas extends Model
{
    use HasFactory;

    protected $table = 'uraian_tugas';

    protected $guarded = ['id'];
}
