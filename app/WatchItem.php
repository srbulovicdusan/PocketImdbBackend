<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchItem extends Model
{
    protected $fillable = ['movie_id', 'user_id', 'watched'];

    public function movie(){
        return $this->belongsTo('App\Movie', 'movie_id');
    }
}
