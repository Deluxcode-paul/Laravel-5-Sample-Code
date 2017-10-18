<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('user_id');
            $table->text('details');
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('general_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('general_answer_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('answer_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('answer_id')->references('id')->on('general_answers')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('general_answer_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('answer_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('answer_id')->references('id')->on('general_answers')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general_answer_reports');
        Schema::drop('general_answer_votes');
        Schema::drop('general_answers');
    }
}
