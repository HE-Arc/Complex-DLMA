<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    $user_id = DB::table('users')
                  ->inRandomOrder()
                  ->first()->id;
    $choice_1_id = DB::table('choices')
                  ->inRandomOrder()
                  ->first()->id;
    $choice_2_id = DB::table('choices')
                  ->inRandomOrder()
                  ->first()->id;
    return [
        'title' => $faker->realText(50),
        'user_id' => $user_id,
        'choice_1_id' => $choice_1_id,
        'choice_2_id' => $choice_2_id,
        'report_counter' => rand(0, 1000),
    ];
});
