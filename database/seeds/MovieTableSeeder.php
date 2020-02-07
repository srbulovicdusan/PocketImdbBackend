<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Movie;

class MovieTableSeeder extends Seeder
{
    public function run()
    {
        factory(Movie::class, 50)->create();
        
        Movie::createIndex();
        $mappingProperties = array(
            'title' => array(
                 'type' => 'keyword'
             )
       );
       Movie::addAllToIndex();
        
    }
}
