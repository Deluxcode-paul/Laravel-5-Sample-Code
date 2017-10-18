<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('user_id');
            $table->text('details');
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::table('recipe_questions', function (Blueprint $table) {
            $table->unsignedInteger('answers')->default(0)->after('reports');
        });

        Schema::create('recipe_answer_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_answer_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('recipe_answer_id')->references('id')->on('recipe_answers')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('recipe_answer_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_answer_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('recipe_answer_id')->references('id')->on('recipe_answers')
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
        Schema::drop('recipe_answer_reports');
        Schema::drop('recipe_answer_votes');
        Schema::drop('recipe_answers');

        Schema::table('recipe_questions', function (Blueprint $table) {
            $table->dropColumn('answers');
        });
    }
}
