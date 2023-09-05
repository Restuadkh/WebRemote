<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogApache extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_server',
        'datetime',
        'method', 
        'uri',
        'status',
        'bytes',
        'user_agent',
    ];

}
