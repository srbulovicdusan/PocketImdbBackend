<?php

use Faker\Generator as Faker;
use App\Genre;
use App\MovieImage;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Movie::class, function (Faker $faker) {
    $genreCount = Genre::all()->count();
    $rand = rand(1, $genreCount);
    $imageCount = MovieImage::all()->count();
    $randImage = rand(1, $imageCount);
    return [
        'title' => $faker->words(2, true),
        'description' => $faker->paragraph(10, true),
        'image_id' => $randImage,
        'genre_id' => $rand
    ];
});
