<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecipeRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createRecipeHasAllergen();
        $this->createRecipeHasCuisine();
        $this->createRecipeHasDiet();
        $this->createRecipeHasHoliday();
        $this->createRecipeHasSource();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recipe_has_source');
        Schema::drop('recipe_has_holiday');
        Schema::drop('recipe_has_diet');
        Schema::drop('recipe_has_cuisine');
        Schema::drop('recipe_has_allergen');
    }

    /**
     * @return void
     */
    private function createRecipeHasAllergen()
    {
        Schema::create('recipe_has_allergen', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('allergen_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('allergen_id')->references('id')->on('allergens')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    private function createRecipeHasCuisine()
    {
        Schema::create('recipe_has_cuisine', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('cuisine_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('cuisine_id')->references('id')->on('cuisines')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    private function createRecipeHasDiet()
    {
        Schema::create('recipe_has_diet', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('diet_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('diet_id')->references('id')->on('diets')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    private function createRecipeHasHoliday()
    {
        Schema::create('recipe_has_holiday', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('holiday_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('holiday_id')->references('id')->on('holidays')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * @return void
     */
    private function createRecipeHasSource()
    {
        Schema::create('recipe_has_source', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recipe_id');
            $table->unsignedInteger('source_id');
            $table->timestamps();

            $table->foreign('recipe_id')->references('id')->on('recipes')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }
}
