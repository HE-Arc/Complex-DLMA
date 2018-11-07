<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 190);

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('choice_1_id');
            $table->unsignedInteger('choice_2_id');

            $table->unsignedInteger('report_counter');

            $table->timestamps();
        });

        Schema::table('questions', function($table)
        {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('choice_1_id')->references('id')->on('choices')->onUpdate('cascade');
            $table->foreign('choice_2_id')->references('id')->on('choices')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
