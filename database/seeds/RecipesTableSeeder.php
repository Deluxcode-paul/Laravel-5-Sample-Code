<?php

use App\Facades\BfmImage;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\RecipeCategory;
use App\Models\Allergen;
use App\Models\Cuisine;
use App\Models\Diet;
use App\Models\Holiday;
use App\Models\Source;
use App\Models\RecipeViews;
use App\Models\RecipeShares;
use App\Models\IngredientGroup;
use App\Models\RecipeIngredient;
use Illuminate\Support\Facades\DB;
use App\Models\RecipeCooking;
use App\Models\CookingStep;
use App\Models\Review;
use App\Models\RecipeQuestion;
use App\Models\User;
use App\Models\ReviewComment;
use App\Models\RecipeAnswer;
use App\Models\Video;

/**
 * Class RecipesTableSeeder
 */
class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('production' != env('APP_ENV', 'local')) {
            //$this->truncate();

            factory(IngredientGroup::class, 20)->create();

            factory(Recipe::class, 100)->create()->each(function ($recipe) {
                $this->recipeGeneralData($recipe);
                $this->recipeViewAndShares($recipe);
                $this->recipeIngredients($recipe);
                $this->recipeDirections($recipe);
                $this->recipeReviews($recipe);
                $this->recipeQuestions($recipe);
                $this->recipeVideos($recipe);
                $this->recipeMainImage($recipe);
            });
        }
    }

    /**
     * @param $recipe
     */
    private function recipeMainImage($recipe)
    {
        $sourceFilePath = public_path('seeds/recipe_images') . '/' . $recipe->image;
        $targetFilePath = BfmImage::generateFullPath(basename($sourceFilePath));
        $recipe->image = BfmImage::save($sourceFilePath, $targetFilePath);
        $recipe->save();
    }

    /**
     * @param $recipe
     */
    private function recipeGeneralData($recipe)
    {
        $tags = Tag::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $categories = RecipeCategory::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $allergens = Allergen::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $cuisines = Cuisine::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $diets = Diet::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $holidays = Holiday::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
        $sources = Source::inRandomOrder()->take(3)->get()->pluck('id')->toArray();

        $recipe->tags()->sync($tags);
        $recipe->categories()->sync($categories);
        $recipe->allergens()->sync($allergens);
        $recipe->cuisines()->sync($cuisines);
        $recipe->diets()->sync($diets);
        $recipe->holidays()->sync($holidays);
        $recipe->sources()->sync($sources);
    }

    /**
     * @param $recipe
     */
    private function recipeViewAndShares($recipe)
    {
        $views = new RecipeViews();
        $views->views = rand(1, 1000);
        $recipe->views()->save($views);

        $shares = new RecipeShares();
        $shares->shares = rand(1, 1000);
        $recipe->shares()->save($shares);
    }

    /**
     * @param $recipe
     */
    private function recipeIngredients($recipe)
    {
        factory(RecipeIngredient::class, 20)->make()->each(function ($ingredient) use ($recipe) {
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        });
    }

    private function recipeDirections($recipe)
    {
        factory(RecipeCooking::class, 3)->make()->each(function ($direction) use ($recipe) {
            $direction->recipe_id = $recipe->id;
            $direction->save();

            for ($i = 1; $i <= rand(3, 5); $i++) {
                $cookingStep = factory(CookingStep::class)->make();
                $cookingStep->user_id = $recipe->user_id;
                $direction->steps()->save($cookingStep);
            }
        });
    }

    /**
     * @param $recipe
     */
    private function recipeReviews($recipe)
    {
        factory(Review::class, 10)->make()->each(function ($review) use ($recipe) {
            $review->recipe_id = $recipe->id;
            $review->save();

            $tags = Tag::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $review->tags()->sync($tags);

            $chefs = User::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $review->chefs()->sync($chefs);

            for ($i = 1; $i <= 5; $i++) {
                $comment = factory(ReviewComment::class)->make();
                $review->comments()->save($comment);
            }
        });
    }

    /**
     * @param $recipe
     */
    private function recipeQuestions($recipe)
    {
        factory(RecipeQuestion::class, 10)->make()->each(function ($question) use ($recipe) {
            $question->recipe_id = $recipe->id;
            $question->save();

            $tags = Tag::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $question->tags()->sync($tags);

            $chefs = User::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $question->chefs()->sync($chefs);

            for ($i = 1; $i <= 5; $i++) {
                $answer = factory(RecipeAnswer::class)->make();
                $question->answers()->save($answer);
            }
        });
    }

    /**
     * @param $recipe
     */
    private function recipeVideos($recipe)
    {
        factory(Video::class, 3)->make()->each(function ($video) use ($recipe) {
            $video->owner_id = $recipe->id;
            $video->is_featured = $recipe->is_featured;
            $video->user_id = $recipe->user_id;
            $video->save();

            $tags = Tag::inRandomOrder()->take(3)->get()->pluck('id')->toArray();
            $video->tags()->sync($tags);
        });
    }

    protected function truncate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('recipes')->truncate();
        DB::table('recipe_has_tag')->truncate();
        DB::table('recipe_has_category')->truncate();
        DB::table('recipe_has_allergen')->truncate();
        DB::table('recipe_has_cuisine')->truncate();
        DB::table('recipe_has_diet')->truncate();
        DB::table('recipe_has_holiday')->truncate();
        DB::table('recipe_has_source')->truncate();
        DB::table('ingredient_groups')->truncate();
        DB::table('recipe_ingredients')->truncate();
        DB::table('recipe_cooking')->truncate();
        DB::table('cooking_steps')->truncate();
        DB::table('reviews')->truncate();
        DB::table('review_has_tag')->truncate();
        DB::table('review_has_chef')->truncate();
        DB::table('recipe_questions')->truncate();
        DB::table('recipe_question_has_tag')->truncate();
        DB::table('recipe_question_has_chef')->truncate();
        DB::table('recipe_answers')->truncate();
        DB::table('review_comments')->truncate();
        DB::table('videos')->truncate();
        DB::table('video_has_tag')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
