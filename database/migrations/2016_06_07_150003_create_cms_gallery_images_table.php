<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsGalleryImagesTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_gallery_images', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('gallery_id');
            $table->unsignedInteger('position');
            $table->string('url');
            
            $table->foreign('gallery_id')
                ->references('id')
                ->on('cms_galleries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_gallery_images');
    }
}
