<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_server',
        'usage_cpu',
        'core_cpu',
    ];
}
