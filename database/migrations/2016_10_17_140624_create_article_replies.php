<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_comment_id');
            $table->unsignedInteger('user_id');
            $table->text('details');
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->timestamps();

            $table->foreign('article_comment_id')->references('id')->on('article_comments')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('article_reply_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_reply_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('article_reply_id')->references('id')->on('article_replies')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('article_reply_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_reply_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('article_reply_id')->references('id')->on('article_replies')
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
        Schema::drop('article_reply_reports');
        Schema::drop('article_reply_votes');
        Schema::drop('article_replies');
    }
}
