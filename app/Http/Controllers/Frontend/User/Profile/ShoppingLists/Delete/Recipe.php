<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Delete;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\ShoppingLists\RecipeRequest;

class Recipe extends AbstractProfile
{
    /**
     * @param RecipeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(RecipeRequest $request)
    {
        $this->currentUser->deleteRecipesFromShoppingList($request->get('recipes'));

        return redirect()->route('user.profile.shopping-lists.view');
    }
}
