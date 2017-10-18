<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_id');
            $table->unsignedInteger('user_id');
            $table->text('details');
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('reviews')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedInteger('comments')->default(0)->after('reports');
        });

        Schema::create('review_comment_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_comment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('review_comment_id')->references('id')->on('review_comments')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('review_comment_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('review_comment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('review_comment_id')->references('id')->on('review_comments')
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
        Schema::drop('review_comment_reports');
        Schema::drop('review_comment_votes');
        Schema::drop('review_comments');

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('comments');
        });
    }
}
