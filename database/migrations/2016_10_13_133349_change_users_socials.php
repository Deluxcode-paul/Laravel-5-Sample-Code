<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('social_facebook', 'facebook');
            $table->renameColumn('social_instagram', 'instagram');
            $table->renameColumn('social_twitter', 'twitter');
            $table->renameColumn('social_youtube', 'youtube');
            $table->renameColumn('social_pinterest', 'pinterest');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('facebook', 'social_facebook');
            $table->renameColumn('instagram', 'social_instagram');
            $table->renameColumn('twitter', 'social_twitter');
            $table->renameColumn('youtube', 'social_youtube');
            $table->renameColumn('pinterest', 'social_pinterest');
        });
    }
}
