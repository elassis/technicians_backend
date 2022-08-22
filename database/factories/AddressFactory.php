<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;
use App\City;
use App\User;


$factory->define(Address::class, function (Faker $faker) {
    return [
        //get the id randomly of both created tables
        'city_id' =>  City::inRandomOrder()->first()->id,
        'user_id' =>  User::inRandomOrder()->first()->id,
        'street'  =>  $faker->streetName,
        'sector'  =>  $faker->city,
        'number'  =>  $faker->randomDigit
    ];
});
