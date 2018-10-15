<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', 
            function($table)
            {
                $table->dropColumn('id');
                $table->string('email', 190)->change();
                $table->string('nickname', 15)->change();
                $table->unsignedInteger('role');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',
        function($table)
        {
            $table->increments('id');
            $table->string('nickname')->change();
            $table->string('email')->change();
            $table->string('password')->change();
            $table->dropColumn('role'); 
        });
    }
}
