<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Share;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\ShoppingLists\RecipeRequest;

class GetPrint extends AbstractProfile
{
    /**
     * @param RecipeRequest $request
     * @return mixed
     */
    public function __invoke(RecipeRequest $request)
    {
        $shoppingList = $this->currentUser->getShoppingList($request->get('recipes'));

        return view('user.profile.shopping_lists.print', compact('shoppingList'));
    }
}
