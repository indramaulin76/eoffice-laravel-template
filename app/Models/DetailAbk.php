<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAbk extends Model
{
    use HasFactory;

    protected $table = 'detail_abk';

    protected $guarded = ['id'];
}
