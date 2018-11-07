<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
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
                $table->renameColumn('nickname', 'username');
                $table->rememberToken();
                $table->increments('id');
                $table->timestamp('email_verified_at')->nullable();
            }
        );

        // Why I'm using that : http://kodeinfo.com/post/moving-column-in-migration-laravel/
        DB::statement("ALTER TABLE users MODIFY COLUMN id INT(10) unsigned auto_increment FIRST");
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
                $table->renameColumn('username', 'nickname');
                $table->dropColumn('remember_token');
                $table->dropColumn('id');
                $table->dropColumn('email_verified_at');
            }
        );
    }
}
