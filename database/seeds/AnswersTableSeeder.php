<?php

use Illuminate\Database\Seeder;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = DB::table('users')
                ->inRandomOrder()
                ->first()->id;

        $question_id = DB::table('questions')
                ->inRandomOrder()
                ->first()->id;

        DB::table('answers')->insert([
            'user_id' => $user_id,
            'question_id' => $question_id,
            'choice' => random_int(0, 1),
        ]);
    }
}
