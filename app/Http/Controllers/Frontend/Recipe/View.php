<?php

namespace App\Http\Controllers\Frontend\Recipe;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use App\Events\Recipe\RecipeViewed;
use Assets;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Recipe
 */
class View extends Controller
{
    protected $recipe;

    const COUNT_ALLERGENS = 5;
    const COUNT_OF_REVIEWS = 3;

    /**
     * @param $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($id, $slug = '')
    {
        $this->recipe = Recipe::find($id);
        if (empty($this->recipe)) {
            abort(404);
        }

        if (empty($slug)) {
            return redirect()->to($this->recipe->getUrl());
        }

        return $this->init();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function init()
    {
        /** @var Collection $allergens */
        $allergens = $this->recipe->allergens()->getResults();

        event(new RecipeViewed($this->recipe));

        Assets::group('frontend')->addJs('share/social.js');
        Assets::group('frontend')->addJs('share/email.js');
        Assets::group('frontend')->addJs('user/profile/activity.js');

        return $this->render([
            'reviewsPage' => $this->recipe->getReviewsPage(),
            'questionsPage' => $this->recipe->getQuestionsPage(),
            'recipe' => $this->recipe,
            'gallery' => $this->recipe->getMedia(),
            'user' => $this->recipe->user()->getResults(),
            'allergens' => $allergens,
            'relatedRecipes' => $this->recipe->getRelatedRecipes(),
            'relatedArticles' => $this->recipe->getRelatedArticles()
        ]);
    }

    /**
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($options)
    {
        return view('recipe.view', $options);
    }
}
