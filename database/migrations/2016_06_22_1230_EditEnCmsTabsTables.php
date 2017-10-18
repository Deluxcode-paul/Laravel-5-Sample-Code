<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditEnCmsTabsTables extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_tabs_en', function (Blueprint $table) {
            $table->renameColumn('title', 'heading');
        });

        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->renameColumn('title', 'image');
            $table->unsignedInteger('position');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_tabs_en', function (Blueprint $table) {
            $table->renameColumn('heading', 'title');
        });

        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->renameColumn('image', 'title');
            $table->dropColumn('position');
        });
    }
}
