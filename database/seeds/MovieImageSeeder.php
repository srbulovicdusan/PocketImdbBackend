<?php

use App\MovieImage;
use Illuminate\Database\Seeder;

class MovieImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MovieImage::class, 50)->create();
    }
}
