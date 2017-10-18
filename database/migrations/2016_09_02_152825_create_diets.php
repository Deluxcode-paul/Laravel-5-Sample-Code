<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('diet_has_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diet_id');
            $table->unsignedInteger('preference_id');
            $table->timestamps();

            $table->foreign('diet_id')->references('id')->on('diets')
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
        Schema::drop('diet_has_preference');
        Schema::drop('diets');
    }
}
