<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $user_id = DB::table('users')
                  ->inRandomOrder()
                  ->first()->id;
    $question_id = DB::table('questions')
                   ->inRandomOrder()
                    ->first()->id;
                    
    return [
        'user_id' => $user_id,
        'question_id' => $question_id,
        'text' => $faker->realText(100)
    ];
});
