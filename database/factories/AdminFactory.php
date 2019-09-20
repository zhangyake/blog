<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->email,
        'password' => bcrypt('123456'), // password
    ];
});
