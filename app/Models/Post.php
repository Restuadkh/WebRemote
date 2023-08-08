<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Casts\Attribute as Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
    ];

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn ($content) => asset('/storage/posts/' . $content),
        );
    }
}
