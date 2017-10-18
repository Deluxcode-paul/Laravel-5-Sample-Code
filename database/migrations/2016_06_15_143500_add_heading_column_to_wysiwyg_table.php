<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadingColumnToWysiwygTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('cms_wysiwyg', function (Blueprint $table) {
            $table->string('heading')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('cms_wysiwyg', function (Blueprint $table) {
            $table->dropColumn('heading');
        });
    }
}
