<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profession;
use Faker\Generator as Faker;

$factory->define(Profession::class, function (Faker $faker) {
  return [
    'name' => $faker->jobTitle
  ];
});
