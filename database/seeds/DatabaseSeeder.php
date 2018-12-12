<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call all seeders in a specific order.
        $this->call([
            UsersTableSeeder::class,
            ChoicesTableSeeder::class,
            QuestionsTableSeeder::class,
            AnswersTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
