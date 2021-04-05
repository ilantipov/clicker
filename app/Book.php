<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }


}
