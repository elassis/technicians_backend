<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Street;
use Faker\Generator as Faker;
use App\Sector;

$factory->define(Street::class, function (Faker $faker) {
  return [
    'street_name' => $faker->name,
    'sector_id'   => Sector::inRandomOrder()->first()->id,
  ];
});
