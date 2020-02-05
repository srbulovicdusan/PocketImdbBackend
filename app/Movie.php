<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'image_url', 'description'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function reactions(){
        return $this->hasMany('App\UserReaction');
    }
    public function genre(){
        return $this->hasOne(Genre::class);
    }
}
