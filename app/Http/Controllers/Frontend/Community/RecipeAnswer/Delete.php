<?php

namespace App\Http\Controllers\Frontend\Community\RecipeAnswer;

use App\Http\Controllers\Controller;
use App\Models\RecipeAnswer;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Delete extends Controller
{
    /**
     * @param RecipeAnswer $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeAnswer $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
