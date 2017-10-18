<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsFaqItemsTable extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('cms_faq_items', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('faq_id');
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('position');

            $table->foreign('faq_id')
                ->references('id')
                ->on('cms_faqs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('cms_faq_items');
    }
}
