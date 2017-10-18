<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTwoColumnWysiwygTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_two_column_wysiwyg', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('heading');
            $table->text('column1');
            $table->text('column2');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_two_column_wysiwyg');
    }
}
