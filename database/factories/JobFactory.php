<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;
use App\Technician;
use App\User;


$factory->define(Job::class, function (Faker $faker) {
    return [
        'technician_id' => Technician::inRandomOrder()->first()->id,
        'user_id' => User::inRandomOrder()->first()->id,
        'comments' => $faker->text,
    ];
});
