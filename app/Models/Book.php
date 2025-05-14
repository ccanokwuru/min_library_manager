<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'authors',
        'isbn',
        'description',
        'feilds',
        'publisher',
        'is_available',
        'quantity',
        'edition',
    ];
}
