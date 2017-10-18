<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWysiwygFields extends Migration
{
    public function up()
    {
        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });

        Schema::table('cms_two_column_wysiwygs_en', function (Blueprint $table) {
            $table->longText('column1')->nullable()->change();
            $table->longText('column2')->nullable()->change();
        });

        Schema::table('cms_wysiwygs_en', function (Blueprint $table) {
            $table->longText('content')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
        });

        Schema::table('cms_two_column_wysiwygs_en', function (Blueprint $table) {
            $table->text('column1')->nullable()->change();
            $table->text('column2')->nullable()->change();
        });

        Schema::table('cms_wysiwygs_en', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
        });
    }
}
