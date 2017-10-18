<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCmsGalleriesEnTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_galleries_en', function (Blueprint $table) {
            $table->renameColumn('title', 'heading');
            $table->dropColumn('button_text');
            $table->dropColumn('images_quantity');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_galleries_en', function (Blueprint $table) {
            $table->renameColumn('heading', 'title');
            $table->string('button_text');
            $table->unsignedInteger('images_quantity');
        });
    }
}
