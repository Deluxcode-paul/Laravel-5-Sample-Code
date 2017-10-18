<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CookingStepsAddReordering extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_steps', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable()->after('image');
            $table->unsignedInteger('lft')->nullable()->after('parent_id');
            $table->unsignedInteger('rgt')->nullable()->after('lft');
            $table->unsignedInteger('depth')->nullable()->after('rgt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cooking_steps', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('depth');
        });
    }
}
