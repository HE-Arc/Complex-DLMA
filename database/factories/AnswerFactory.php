<?php

use Faker\Generator as Faker;

// Factory which creates fake answers with a real user on a real question of the db 
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
