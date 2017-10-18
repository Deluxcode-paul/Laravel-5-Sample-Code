<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRecipeSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('recipe_steps', 'recipe_cooking');

        Schema::table('recipe_cooking', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::create('cooking_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cooking_id');
            $table->unsignedInteger('user_id');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('cooking_id')->references('id')->on('recipe_cooking')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('cooking_steps');

        Schema::rename('recipe_cooking', 'recipe_steps');

        Schema::table('recipe_steps', function (Blueprint $table) {
            $table->longText('description')->change();
        });
    }
}
