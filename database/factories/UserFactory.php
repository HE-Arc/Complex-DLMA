<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'username' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('pass1234'), // secret
        'role' => rand(0, 1024),
    ];
});
