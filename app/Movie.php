<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;
class Movie extends Model
{
    use ElasticquentTrait;
    protected $fillable = ['title', 'description', 'image_url', 'genre_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function reactions(){
        return $this->hasMany('App\UserReaction');
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
