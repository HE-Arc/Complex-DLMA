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
        $answers = factory(App\Answer::class, 400)->make();
        foreach ($answers as $answer) {
            repeat:
            // test each generated answer and regenerates it if the composite primary key already exists.
            try {
                $answer->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $answer = factory(App\Answer::class)->make();
                goto repeat;
            }
        }
    }
}
