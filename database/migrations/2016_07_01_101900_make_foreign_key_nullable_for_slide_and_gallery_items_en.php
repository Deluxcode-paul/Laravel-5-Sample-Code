<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeForeignKeyNullableForSlideAndGalleryItemsEn extends Migration
{
    public function up()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->unsignedInteger('gallery_id')
                ->nullable()
                ->change();

            $table->dropForeign('cms_gallery_items_en_gallery_id_foreign');
            $table->dropIndex('cms_gallery_items_en_gallery_id_foreign');
        });

        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->unsignedInteger('slider_id')
                ->nullable()
                ->change();

            $table->dropForeign('cms_slider_items_en_slider_id_foreign');
            $table->dropIndex('cms_slider_items_en_slider_id_foreign');
        });
    }

    public function down()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->unsignedInteger('gallery_id')
                ->nullable(false)
                ->change();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('cms_galleries_en')
                ->onDelete('cascade');
        });

        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->unsignedInteger('slider_id')
                ->nullable(false)
                ->change();

            $table->foreign('slider_id')
                ->references('id')
                ->on('cms_sliders_en')
                ->onDelete('cascade');
        });
    }
}
