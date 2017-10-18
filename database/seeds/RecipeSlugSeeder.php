<?php

use App\Models\Recipe;
use Illuminate\Database\Seeder;

/**
 * Class RecipeSlugSeeder
 */
class RecipeSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = Recipe::whereNull('slug')->get();
        foreach ($recipes as $recipe) {
            $recipe->save();
        }
    }
}
