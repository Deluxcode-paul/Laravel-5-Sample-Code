<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBfmFormsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bfm_forms_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('form_id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->string('wrapper_id')->nullable();
            $table->string('wrapper_class')->nullable();
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('type');
            $table->string('validation_be')->nullable();
            $table->string('validation_fe')->nullable();
            $table->string('fieldset')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_multiple')->default(false);
            $table->enum('data_type', ['int', 'varchar', 'text']);
            $table->boolean('is_shown_in_grid')->default(false);
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
        Schema::drop('bfm_forms_fields');
    }
}
