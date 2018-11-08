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
        $users = factory(App\User::class, 200)->make();
        foreach ($users as $user) {
            repeat:
            try {
                $user->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $user = factory(App\User::class)->make();
                goto repeat;
            }
        }
    }
}
