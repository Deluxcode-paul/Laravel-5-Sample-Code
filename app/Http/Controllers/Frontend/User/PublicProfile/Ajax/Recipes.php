<?php

namespace App\Http\Controllers\Frontend\User\PublicProfile\Ajax;

use App\Http\Controllers\Controller;
use App\Models\User;

class Recipes extends Controller
{
    public function __invoke(User $user)
    {
        $perPage = config('kosher.pagination.recipes_public_profile');
        $recipes = $user->recipes()->paginate($perPage);
        $content = view('user.public_profile.view.recipes.items', compact('recipes'))->render();
        $hasMorePages = $recipes->hasMorePages();

        return response()->json(compact('content', 'hasMorePages'));
    }
}
