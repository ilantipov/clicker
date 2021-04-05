<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function books()
    {
        $this->hasMany(Book::class);
    }
}
