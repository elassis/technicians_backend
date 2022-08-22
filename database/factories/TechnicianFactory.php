<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Technician;
use Faker\Generator as Faker;
use App\User;

$factory->define(Technician::class, function (Faker $faker) {
    return [
        'user_id'    => User::inRandomOrder()->first()->id,
        'available'  => $faker->boolean($chanceOfGettingTrue = 50),
        'price_hour' => $faker->numberBetween($min = 200, $max = 500),
    ];
});
