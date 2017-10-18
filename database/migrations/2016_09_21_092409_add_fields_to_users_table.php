<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('last_name');
            $table->string('social_facebook')->nullable()->after('bio');
            $table->string('social_instagram')->nullable()->after('social_facebook');
            $table->string('social_twitter')->nullable()->after('social_instagram');
            $table->string('social_youtube')->nullable()->after('social_twitter');
            $table->string('social_pinterest')->nullable()->after('social_youtube');
            $table->string('website')->nullable()->after('social_pinterest');
            $table->timestamp('deleted_at')->nullable()->after('updated_at');
            //
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

            $table->dropColumn('bio');
            $table->dropColumn('social_facebook');
            $table->dropColumn('social_instagram');
            $table->dropColumn('social_twitter');
            $table->dropColumn('social_youtube');
            $table->dropColumn('social_pinterest');
            $table->dropColumn('website');
            $table->dropColumn('deleted_at');
            //
        });
    }
}
