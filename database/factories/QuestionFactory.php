<?php

use Faker\Generator as Faker;

// Factory which creates fake questions with a real user and real choices with real text (faker)
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
        'description' => $faker->realText(190),
        'user_id' => $user_id,
        'choice_1_id' => $choice_1_id,
        'choice_2_id' => $choice_2_id,
        'report_counter' => rand(0, 1000),
    ];
});
