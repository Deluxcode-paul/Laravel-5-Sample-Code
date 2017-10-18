<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('allergen_has_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('allergen_id');
            $table->unsignedInteger('preference_id');
            $table->timestamps();

            $table->foreign('allergen_id')->references('id')->on('allergens')
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
        Schema::drop('allergen_has_preference');
        Schema::drop('allergens');
    }
}
