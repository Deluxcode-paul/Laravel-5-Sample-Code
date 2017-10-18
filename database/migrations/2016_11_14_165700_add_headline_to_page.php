<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadlineToPage extends Migration
{
    public function up()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->string('headline')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->dropColumn('headline');
        });
    }
}
