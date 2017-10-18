<?php

namespace App\Http\Controllers\Frontend\Search\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientGet extends Controller
{
    public function __invoke(Request $request)
    {
        $word = $request->get('w');

        $result = Ingredient::where('title', 'like', '%'.$word.'%')
            ->pluck('title', 'id');

        return response()->json($result);
    }
}
