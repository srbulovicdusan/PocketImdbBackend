<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieImage extends Model
{
    protected $fillable =['movie_id', 'fullSize', 'thumbnail'];
}
