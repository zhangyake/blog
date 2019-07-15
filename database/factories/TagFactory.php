<?php

use Faker\Generator as Faker;

$factory->define(\App\Tag::class, function (Faker $faker) {
    return [
        'name'=>$faker->unique()->city
    ];
});

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'name'=>$faker->unique()->country
    ];
});