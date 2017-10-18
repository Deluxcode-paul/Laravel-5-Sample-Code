<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsWysiwygTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_wysiwyg', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_wysiwyg');
    }
}
