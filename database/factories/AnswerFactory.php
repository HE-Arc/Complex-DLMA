<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    $user_id = DB::table('users')
                  ->inRandomOrder()
                  ->first()->id;
    $question_id = DB::table('questions')
                  ->inRandomOrder()
                  ->first()->id;
    return [
        'user_id' => $user_id,
        'question_id' => $question_id,
        'choice' => rand(1, 2),
    ];
});
