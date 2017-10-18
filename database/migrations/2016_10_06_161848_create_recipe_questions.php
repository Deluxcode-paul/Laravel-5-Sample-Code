<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('details');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();
        });

        Schema::create('recipe_question_has_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('recipe_question_has_chef', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('chef_id');
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('chef_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('recipe_question_views', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('recipe_question_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('recipe_question_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_question_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('recipe_question_id')->references('id')->on('recipe_questions')
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
        Schema::drop('recipe_question_reports');
        Schema::drop('recipe_question_votes');
        Schema::drop('recipe_question_views');
        Schema::drop('recipe_question_has_chef');
        Schema::drop('recipe_question_has_tag');
        Schema::drop('recipe_questions');
    }
}
