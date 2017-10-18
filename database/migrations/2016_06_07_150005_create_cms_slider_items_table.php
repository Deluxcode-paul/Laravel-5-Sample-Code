<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsSliderItemsTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_slider_items', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('slider_id');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->unsignedInteger('position');

            $table->foreign('slider_id')
                ->references('id')
                ->on('cms_sliders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_slider_items');
    }
}
