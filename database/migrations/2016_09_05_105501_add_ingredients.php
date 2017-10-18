<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIngredients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('ingredient_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('ingredient_group_id');
            $table->unsignedInteger('ingredient_id');
            $table->string('description');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('ingredient_group_id')->references('id')->on('ingredient_groups')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')
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
        Schema::drop('recipe_ingredients');
        Schema::drop('ingredient_groups');
        Schema::drop('ingredients');
    }
}
