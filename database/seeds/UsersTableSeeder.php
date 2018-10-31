<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => "jamychal",
            'email' => "jamychal@gmail.com",
            'password' => Hash::make('pass1234'),
            'role' => 0,
        ]);
    }
}
