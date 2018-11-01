<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', 
            function($table)
            {
                $table->dropColumn('user_email');
                $table->unsignedInteger('user_id');
                
                $table->primary(['user_id', 'question_id']);

                $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );

        DB::statement("ALTER TABLE answers MODIFY COLUMN user_id INT(10) unsigned FIRST");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', 
            function($table)
            {
                $table->dropColumn('user_id');
                $table->string('user_email', 190);

                $table->dropPrimary('question_id');
                $table->primary('user_email');

                $table->foreign('user_email')->references('email')->on('users')->onDelete('cascade');
            }
        );

        DB::statement("ALTER TABLE answers MODIFY COLUMN user_email VARCHAR(190) NOT NULL FIRST");
    }
}
