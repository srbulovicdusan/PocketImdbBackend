<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReaction extends Model
{
    protected $fillable = ['user_id', 'movie_id', 'type'];
}
