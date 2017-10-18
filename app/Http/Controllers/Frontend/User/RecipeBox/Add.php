<?php

namespace App\Http\Controllers\Frontend\User\RecipeBox;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

/**
 * Class Add
 * @package App\Http\Controllers\Frontend\User\RecipeBox
 */
class Add extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $button = '';
        $ingredients = '';
        $message = '';
        $redirect = '';
        $recipeId = intval(Input::get('recipe'));
        $recipe = Recipe::find($recipeId);

        if (empty($recipe)) {
            $status = 'error';
            $message = trans('recipe/view.recipe_box_error');
        } else {
            /** @var User $user */
            $user = Auth::user();
            if (empty($user)) {
                $status = 'auth';
                $redirect = url('login') . '?destination=' . urlencode($recipe->getUrl());
            } else {
                $user->recipeBox()->detach($recipeId);
                $user->recipeBox()->attach($recipeId);
                $status = 'ok';
                $button = View::make('partials.buttons.saved_recipe')->render();
                $ingredients = View::make('partials.buttons.saved_recipe_ingredients')->render();
                $message = trans('recipe/view.recipe_box_success');
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'button' => $button,
            'ingredients' => $ingredients,
            'redirect' => $redirect
        ]);
    }
}
