<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsPageTemplateTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_page_template', function (Blueprint $table) {
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('template_id');
            $table->string('template_type');
            $table->unsignedInteger('position');

            $table->foreign('page_id')
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
        Schema::drop('cms_page_template');
    }
}
