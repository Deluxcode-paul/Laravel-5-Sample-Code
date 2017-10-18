<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBfmFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bfm_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('elem_id')->nullable();
            $table->string('elem_class')->nullable();
            $table->string('attributes')->nullable();
            $table->string('thank_you_message');
            $table->boolean('has_recaptcha')->default(false);
            $table->boolean('is_page')->default(false);
            $table->string('handler_route')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bfm_forms');
    }
}
