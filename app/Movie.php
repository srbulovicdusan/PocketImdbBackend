<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
class Movie extends Model
{
    protected $fillable = ['title', 'description', 'image', 'genre_id', 'image_id'];

    use ElasticquentTrait;


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
    protected $indexSettings = [
        'analysis' => [
            'analyzer' => [
                'default' => [
                    'tokenizer' => 'keyword',
                ],
            ],
        ],
    ];
    protected $mappingProperties = array(
         'title' => array(
              'type' => 'keyword'
          )
    );
}
