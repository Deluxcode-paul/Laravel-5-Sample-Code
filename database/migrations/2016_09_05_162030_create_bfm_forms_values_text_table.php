<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBfmFormsValuesTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bfm_forms_values_text', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('submit_id');
            $table->unsignedInteger('field_id');
            $table->unsignedInteger('form_id');
            $table->text('value')->nullable();

            $table->foreign('submit_id')
                ->references('id')
                ->on('bfm_forms_submits')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('field_id')
                ->references('id')
                ->on('bfm_forms_fields')
                ->onDelete('cascade')
                ->onUpdate('no action');

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
        Schema::drop('bfm_forms_values_text');
    }
}
