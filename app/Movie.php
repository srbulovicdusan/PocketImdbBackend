<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function reactions(){
        return $this->hasMany('App\UserReaction');
    }
}
