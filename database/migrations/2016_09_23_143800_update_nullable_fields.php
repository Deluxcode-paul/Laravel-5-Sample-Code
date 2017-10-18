<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNullableFields extends Migration
{
    public function up()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('title')->default('')->change();
            $table->string('description')->default('')->change();
            $table->integer('position')->default(0)->change();
        });

        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('title')->default('')->change();
            $table->string('description')->default('')->change();
            $table->integer('position')->default(0)->change();
        });

        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->string('label')->default('')->change();
            $table->string('image')->nullable()->change();
            $table->string('content')->nullable()->change();
            $table->string('button_text')->default('')->change();
            $table->string('button_link')->default('')->change();
            $table->integer('position')->default(0)->change();
        });

        Schema::table('cms_faq_items_en', function (Blueprint $table) {
            $table->integer('position')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->string('image')->change();
            $table->string('title')->change();
            $table->string('description')->change();
            $table->integer('position')->change();
        });

        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->string('image')->change();
            $table->string('title')->change();
            $table->string('description')->change();
            $table->integer('position')->change();
        });

        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->string('label')->change();
            $table->string('image')->change();
            $table->string('content')->change();
            $table->string('button_text')->change();
            $table->string('button_link')->change();
            $table->integer('position')->change();
        });

        Schema::table('cms_faq_items_en', function (Blueprint $table) {
            $table->integer('position')->change();
        });
    }
}
