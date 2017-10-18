<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAboutFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable()->after('bio');
            $table->integer('state_id')->nullable()->after('city');
            $table->string('place_of_work')->nullable()->after('state_id');
            $table->string('status')->nullable()->after('place_of_work');
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
            $table->dropColumn('city');
            $table->dropColumn('state_id');
            $table->dropColumn('place_of_work');
            $table->dropColumn('status');
        });
    }
}
