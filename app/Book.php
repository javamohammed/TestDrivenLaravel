<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    //
    protected $fillable = [
        'title', 'author'
    ];

    public function path()
    {
        # code...
        return '/books/'.$this->id;
    }
}
