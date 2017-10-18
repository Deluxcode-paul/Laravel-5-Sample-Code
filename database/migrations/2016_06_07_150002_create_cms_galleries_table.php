<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsGalleriesTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_galleries', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('button_text');
            $table->unsignedInteger('images_quantity');
            
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_galleries');
    }
}
