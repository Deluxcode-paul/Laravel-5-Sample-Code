<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToPage extends Migration
{
    public function up()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->string('image')->nullable()->after('headline');
        });
    }

    public function down()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
