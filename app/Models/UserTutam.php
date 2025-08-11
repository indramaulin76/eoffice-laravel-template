<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTutam extends Model
{
    use HasFactory;

    protected $table = 'user_tutam';

    protected $guarded = ['id'];
}
