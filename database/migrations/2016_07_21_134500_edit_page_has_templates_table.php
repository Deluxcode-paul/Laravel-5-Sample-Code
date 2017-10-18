<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPageHasTemplatesTable extends Migration
{
    public function up()
    {
        Schema::rename('cms_page_has_templates', 'cms_page_has_template_en');

        Schema::table('cms_page_has_template_en', function (Blueprint $table) {
            $table->increments('id')->before('page_id');

            $table->renameColumn('template_id', 'data');
        });

        DB::statement('ALTER TABLE cms_page_has_template_en MODIFY COLUMN data TEXT');
    }

    public function down()
    {
        Schema::rename('cms_page_has_template_en', 'cms_page_has_templates');

        Schema::table('cms_page_has_templates', function (Blueprint $table) {
            $table->dropColumn('id');

            $table->renameColumn('data', 'template_id');
        });

        DB::statement('ALTER TABLE cms_page_has_templates MODIFY COLUMN template_id INT(10)');
    }
}
