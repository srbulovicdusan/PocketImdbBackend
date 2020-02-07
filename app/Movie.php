<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'description', 'image', 'genre_id', 'image_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function reactions(){
        return $this->hasMany('App\UserReaction');
    }
    public function image(){
        return $this->belongsTo('App\MovieImage');
    }
}
