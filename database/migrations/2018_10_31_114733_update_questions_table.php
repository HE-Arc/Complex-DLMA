<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', 
            function($table)
            {
                $table->dropColumn('user_email');
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
            }
        );

        // Why I'm using that : http://kodeinfo.com/post/moving-column-in-migration-laravel/
        DB::statement("ALTER TABLE questions MODIFY COLUMN user_id INT(10) unsigned NOT NULL AFTER id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', 
            function($table)
            {
                $table->dropColumn('user_id');
                $table->string('user_email', 190);
                $table->foreign('user_email')->references('email')->on('users');
            }
        );

        // Why I'm using that : http://kodeinfo.com/post/moving-column-in-migration-laravel/
        DB::statement("ALTER TABLE questions MODIFY COLUMN user_email VARCHAR(190) NOT NULL AFTER id");
    }
}
