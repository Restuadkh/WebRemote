<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ram extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id_server',
        'usage_ram',
        'space_ram',
    ];
}
