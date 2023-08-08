<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RAM extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_server',
        'usage_ram',
        'space_ram',
    ];
}
