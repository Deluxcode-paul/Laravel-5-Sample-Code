<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Delete;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\ShoppingLists\DeleteIngredientRequest;
use App\Models\ShoppingList;

/**
 * Class Ingredient
 * @package App\Http\Controllers\Frontend\User\Profile\ShoppingLists\Delete
 */
class Ingredient extends AbstractProfile
{
    /**
     * @param DeleteIngredientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DeleteIngredientRequest $request)
    {
        $this->currentUser->deleteIngredientFromShoppingList($request->get('id'));
        $page = $request->get('page', 1);
        $perPage = config('kosher.pagination.shopping_list');
        $offset = $perPage * ($page - 1);

        $count = ShoppingList::where('user_id', $this->currentUser->id)
            ->groupBy('recipe_id')
            ->skip($offset)
            ->take($perPage)
            ->count();

        if (0 == $count) {
            $page = $page - 1;
        }

        if ($page < 1) {
            $page = 1;
        }

        return response()->json([
            'message' => trans('user/profile.ajax_messages.ingredient_deleted'),
            'redirect' => route('user.profile.shopping-lists.view') . '?page=' . $page
        ]);
    }
}
