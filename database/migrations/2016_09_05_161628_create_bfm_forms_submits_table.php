<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBfmFormsSubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bfm_forms_submits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('form_id');
            $table->string('ip');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('form_id')
                ->references('id')
                ->on('bfm_forms')
                ->onDelete('cascade')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bfm_forms_submits');
    }
}
