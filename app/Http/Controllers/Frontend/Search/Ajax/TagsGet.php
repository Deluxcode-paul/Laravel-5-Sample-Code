<?php

namespace App\Http\Controllers\Frontend\Search\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagsGet extends Controller
{
    public function __invoke(Request $request)
    {
        $word = $request->get('query');

        $result = Tag::where('title', 'like', '%'.$word.'%')->pluck('title', 'id');

        return response()->json($result);
    }
}
