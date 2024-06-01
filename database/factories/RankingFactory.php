<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ranking;
use Faker\Generator as Faker;
use App\Technician;
use App\Job;

$factory->define(Ranking::class, function (Faker $faker) {
  return [
    'technician_id' => Technician::inRandomOrder()->first()->id,
    'job_id'        => Job::inRandomOrder()->first()->id,
    'job_ranking'   => $faker->numberBetween($min = 1, $max = 5)
  ];
});
