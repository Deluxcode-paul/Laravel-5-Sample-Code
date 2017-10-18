<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPagesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('keywords');
            $table->string('description');
            $table->string('alias');
            $table->boolean('enabled');
            $table->unsignedInteger('parent_id')->nullable();
            
            $table->foreign('parent_id')
                ->references('id')
                ->on('cms_pages')
                ->onDelete('cascade');
        });
    }

    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_pages');
    }
}
