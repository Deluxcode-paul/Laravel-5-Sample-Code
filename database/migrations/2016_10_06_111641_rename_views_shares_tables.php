<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameViewsSharesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('article_has_share', 'article_shares');
        Schema::rename('article_has_view', 'article_views');
        Schema::rename('recipe_has_share', 'recipe_shares');
        Schema::rename('recipe_has_view', 'recipe_views');

        Schema::table('article_shares', function ($table) {
            $table->unsignedInteger('shares')->default(0)->change();
        });
        Schema::table('article_views', function ($table) {
            $table->unsignedInteger('views')->default(0)->change();
        });
        Schema::table('recipe_shares', function ($table) {
            $table->unsignedInteger('shares')->default(0)->change();
        });
        Schema::table('recipe_views', function ($table) {
            $table->unsignedInteger('views')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('article_shares', 'article_has_share');
        Schema::rename('article_views', 'article_has_view');
        Schema::rename('recipe_shares', 'recipe_has_share');
        Schema::rename('recipe_views', 'recipe_has_view');

        Schema::table('article_has_share', function ($table) {
            $table->unsignedInteger('shares')->change();
        });
        Schema::table('article_has_view', function ($table) {
            $table->unsignedInteger('views')->change();
        });
        Schema::table('recipe_has_share', function ($table) {
            $table->unsignedInteger('shares')->change();
        });
        Schema::table('recipe_has_view', function ($table) {
            $table->unsignedInteger('views')->change();
        });
    }
}
