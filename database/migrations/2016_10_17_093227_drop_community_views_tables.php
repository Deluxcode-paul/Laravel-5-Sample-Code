<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCommunityViewsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('review_views');
        Schema::dropIfExists('recipe_question_views');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('review_views', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
    }
}
