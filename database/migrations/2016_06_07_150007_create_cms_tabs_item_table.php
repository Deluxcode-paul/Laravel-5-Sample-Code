<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTabsItemTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_tabs_item', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('tabs_id');
            $table->string('label');
            $table->string('title');
            $table->text('content');
            $table->string('button_text');
            $table->string('button_link');

            $table->foreign('tabs_id')
                ->references('id')
                ->on('cms_tabs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_tabs_item');
    }
}
