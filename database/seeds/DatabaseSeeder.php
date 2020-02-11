<?php

use App\MovieImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(MovieImageSeeder::class);
        $this->call(MovieTableSeeder::class);
        
    }
}
