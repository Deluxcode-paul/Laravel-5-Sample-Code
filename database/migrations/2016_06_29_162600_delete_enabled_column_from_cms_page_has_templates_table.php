<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteEnabledColumnFromCmsPageHasTemplatesTable extends Migration
{
    public function up()
    {
        Schema::table('cms_page_has_templates', function (Blueprint $table) {
            $table->dropColumn('enabled');
        });
    }

    public function down()
    {
        Schema::table('cms_page_has_templates', function (Blueprint $table) {
            $table->boolean('enabled');
        });
    }
}
