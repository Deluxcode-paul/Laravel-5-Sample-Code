<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthYearFieldsToCommunityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_questions', function (Blueprint $table) {
            $table->unsignedSmallInteger('activity_month')->nullable();
            $table->unsignedSmallInteger('activity_year')->nullable();
        });
        Schema::table('article_comments', function (Blueprint $table) {
            $table->unsignedSmallInteger('activity_month')->nullable();
            $table->unsignedSmallInteger('activity_year')->nullable();
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedSmallInteger('activity_month')->nullable();
            $table->unsignedSmallInteger('activity_year')->nullable();
        });
        Schema::table('recipe_questions', function (Blueprint $table) {
            $table->unsignedSmallInteger('activity_month')->nullable();
            $table->unsignedSmallInteger('activity_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_questions', function (Blueprint $table) {
            $table->dropColumn('activity_month');
            $table->dropColumn('activity_year');
        });
        Schema::table('article_comments', function (Blueprint $table) {
            $table->dropColumn('activity_month');
            $table->dropColumn('activity_year');
        });
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('activity_month');
            $table->dropColumn('activity_year');
        });
        Schema::table('recipe_questions', function (Blueprint $table) {
            $table->dropColumn('activity_month');
            $table->dropColumn('activity_year');
        });
    }
}
