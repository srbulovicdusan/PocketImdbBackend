<?php

use Illuminate\Database\Seeder;
use App\Genre;
class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create([
            'name' => 'comedy'
        ]);
        Genre::create([
            'name' => 'drama'
        ]);
        Genre::create([
            'name' => 'action'
        ]);
        Genre::create([
            'name' => 'fantasy'
        ]);
        Genre::create([
            'name' => 'crime'
        ]);
    }
}
