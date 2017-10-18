<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHiddenColumnForGalleryAndSliderItemsEn extends Migration
{
    public function up()
    {
        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(0);
        });

        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(0);
        });
    }

    public function down()
    {
        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });

        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
}
