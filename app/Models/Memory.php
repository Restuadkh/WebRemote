<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    use HasFactory;
    
    // protected $table = 'memorys';
    public $timestamps = false;

    protected $fillable = [
        'id_server',
        'usage_ram',
        'space_ram',
        'usage_swap',
        'space_swap',
    ];

}
