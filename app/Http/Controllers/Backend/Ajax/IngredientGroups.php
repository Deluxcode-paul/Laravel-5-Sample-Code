<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

/**
 * Class IngredientGroups
 * @package App\Http\Controllers\Backend\Ajax
 */
class IngredientGroups extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $response = [];
        $query = $request->get('query');
        $recipeId = intval($request->get('recipe'));
        $recipe = Recipe::find($recipeId);

        if ($recipe) {
            $groups = $recipe->getIngredientGroups($query);

            foreach ($groups as $group) {
                $response[] = [
                    'id' => $group,
                    'text' => $group
                ];
            }
        }

        return json_encode($response);
    }
}
