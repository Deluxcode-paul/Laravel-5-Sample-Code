<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsSlidersTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_sliders', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');            
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_sliders');
    }
}
