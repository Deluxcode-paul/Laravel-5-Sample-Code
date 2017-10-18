<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnabledColumnToCmsPageTemplateTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_page_template', function (Blueprint $table) {
            $table->boolean('enabled')->after('position');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_page_template', function (Blueprint $table) {
            $table->dropColumn('enabled');
        });
    }
}
