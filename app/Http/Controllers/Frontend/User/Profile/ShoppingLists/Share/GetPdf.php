<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Share;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\ShoppingLists\RecipeRequest;
use PDF;

class GetPdf extends AbstractProfile
{
    /**
     * @param RecipeRequest $request
     * @return mixed
     */
    public function __invoke(RecipeRequest $request)
    {
        $shoppingList = $this->currentUser->getShoppingList($request->get('recipes'));

        $pdf = PDF::loadView('user.profile.shopping_lists.pdf', compact('shoppingList'));

        return $pdf->download('shopping_list_'.date('Y-m-d').'.pdf');
    }
}
