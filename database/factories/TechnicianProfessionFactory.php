<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Technician_profession;
use Faker\Generator as Faker;
use App\Technician;
use App\Profession;

$factory->define(Technician_profession::class, function (Faker $faker) {
  return [
    'technician_id' => Technician::inRandomOrder()->first()->id,
    'profession_id' => Profession::inRandomOrder()->first()->id,
    'price_hour' => $faker->numberBetween($min = 200, $max = 500)
  ];
});
