<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuisines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuisines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('cuisine_has_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cuisine_id');
            $table->unsignedInteger('preference_id');
            $table->timestamps();

            $table->foreign('cuisine_id')->references('id')->on('cuisines')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('preference_id')->references('id')->on('preferences')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cuisine_has_preference');
        Schema::drop('cuisines');
    }
}
