<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    $user_id = DB::table('users')
                  ->inRandomOrder()
                  ->first()->id;
    return [
        'user_id' => $user_id,
        'choice_1' => $faker->realText(50),
        'choice_2' => $faker->realText(50),
        'counter_1' => rand(0, 1000),
        'counter_2' => rand(0, 1000),
        'counter_signaled' => rand(0, 1000),
    ];
});
