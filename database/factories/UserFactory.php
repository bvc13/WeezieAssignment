<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'          => $faker->firstName . ' ' . $faker->lastName,
        'date_of_birth' => $faker->dateTimeBetween('-90 years', 'now'),
        'email'         => $faker->email,
        'country'       => $faker->country,
        'phone_number'  => $faker->unique()->numberBetween(900000000, 999999999),
        'created_at'  => now(),
        'updated_at'  => now()
    ];
});
