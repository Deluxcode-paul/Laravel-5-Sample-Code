<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCmsGalleryItemsEnTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->renameColumn('url', 'image');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->renameColumn('image', 'url');
        });
    }
}
