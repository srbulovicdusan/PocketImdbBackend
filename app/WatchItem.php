<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchItem extends Model
{
    protected $fillable = ['movie_id', 'user_id', 'watched'];
}
