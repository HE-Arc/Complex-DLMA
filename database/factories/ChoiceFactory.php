<?php

use Faker\Generator as Faker;

// Factory which creates fake choices with faker
$factory->define(App\Choice::class, function (Faker $faker) {
    return [
        'text' => $faker->realText(75),
        'counter' => rand(0, 1000),
    ];
});
