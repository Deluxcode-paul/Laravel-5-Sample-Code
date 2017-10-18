<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('details');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('votes')->default(0);
            $table->unsignedInteger('reports')->default(0);
            $table->unsignedInteger('replies')->default(0);
            $table->timestamps();
        });

        Schema::create('article_comment_has_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_comment_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->foreign('article_comment_id')->references('id')->on('article_comments')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('article_comment_has_chef', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_comment_id');
            $table->unsignedInteger('chef_id');
            $table->timestamps();

            $table->foreign('article_comment_id')->references('id')->on('article_comments')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('chef_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('article_comment_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_comment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('article_comment_id')->references('id')->on('article_comments')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
        });

        Schema::create('article_comment_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_comment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('article_comment_id')->references('id')->on('article_comments')
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
        Schema::drop('article_comment_reports');
        Schema::drop('article_comment_votes');
        Schema::drop('article_comment_views');
        Schema::drop('article_comment_has_chef');
        Schema::drop('article_comment_has_tag');
        Schema::drop('article_comments');
    }
}
