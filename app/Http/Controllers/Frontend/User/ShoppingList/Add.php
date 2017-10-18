<?php

namespace App\Http\Controllers\Frontend\User\ShoppingList;

use App\Http\Controllers\Controller;
use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

/**
 * Class Add
 * @package App\Http\Controllers\Frontend\User\ShoppingList
 */
class Add extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!empty($user)) {
            $ingredients = Input::get('ingredients', []);
            $recipeId = Input::get('recipe');
            $message = trans('recipe/view.shopping_list_success');

            if (0 == count($ingredients)) {
                $message = trans('recipe/view.shopping_list_error_count');
            } elseif (false == boolval($recipeId)) {
                $message = trans('recipe/view.shopping_list_error');
            } else {
                ShoppingList::where('user_id', $user->id)->where('recipe_id', $recipeId)->delete();
                foreach ($ingredients as $ingredientId) {
                    $model = ShoppingList::create([
                        'user_id' => $user->id,
                        'recipe_id' => $recipeId,
                        'recipe_ingredient_id' => $ingredientId
                    ]);

                    if (empty($model)) {
                        $message = trans('recipe/view.shopping_list_error');
                    }
                }
            }
        } else {
            $message = trans('auth.not-logged');
        }

        return response()->json(['message' => $message]);
    }
}
