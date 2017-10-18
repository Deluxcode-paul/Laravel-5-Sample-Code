<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('details');
            $table->unsignedTinyInteger('rating')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();
        });

        Schema::create('review_has_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('review_has_chef', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('chef_id');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('chef_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

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

        Schema::create('review_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('review_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
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
        Schema::drop('review_reports');
        Schema::drop('review_votes');
        Schema::drop('review_views');
        Schema::drop('review_has_chef');
        Schema::drop('review_has_tag');
        Schema::drop('reviews');
    }
}
