<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
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

        DB::table('questions')->insert([
            'user_id' => $user_id,
            'choice_1' => str_random(50),
            'choice_2' => str_random(50),
            'counter_1' => random_int(0, 100),
            'counter_2' => random_int(0, 100),
            'counter_signaled' => 0,
        ]);
    }
}
