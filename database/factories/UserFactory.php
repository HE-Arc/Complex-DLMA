<?php

use Faker\Generator as Faker;

// Factory which creates fake users with faker
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('pass1234'), // secret
        'role' => rand(0, 1024),
    ];
});
