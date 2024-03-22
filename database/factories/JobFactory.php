<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Job;
use Faker\Generator as Faker;
use App\Technician;
use App\Profession;
use App\User;


$factory->define(Job::class, function (Faker $faker) {
    return [
        'technician_id' => Technician::inRandomOrder()->first()->id,
        'profession_id' => Profession::inRandomOrder()->first()->id,
        'user_id' => User::inRandomOrder()->first()->id,
        'status' => 'pending',
        'text' => $faker->text,
        'comments' => $faker->text,
    ];
});
