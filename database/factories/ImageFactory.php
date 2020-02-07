<?php

use App\MovieImage;
use Faker\Generator as Faker;

$factory->define(MovieImage::class, function (Faker $faker) {
    return [
        'thumbnail' => $faker->imageUrl(200, 200),
        'fullSize' => $faker->imageUrl(400, 400),

    ];
});
