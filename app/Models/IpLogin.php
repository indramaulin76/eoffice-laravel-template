<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpLogin extends Model
{
    use HasFactory;

    protected $table = 'ip_login';

    protected $guarded = ['id'];
}
