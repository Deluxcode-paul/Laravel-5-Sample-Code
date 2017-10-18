<?php

namespace App\Http\Controllers\Frontend\Recipe;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Events\Recipe\RecipeShared;

class Share extends Controller
{
    /**
     * @param Recipe $recipe
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Recipe $recipe)
    {
        event(new RecipeShared($recipe));

        return response()->json(['message' => trans('share.shared_success'), 'type'=>'success']);
    }
}
