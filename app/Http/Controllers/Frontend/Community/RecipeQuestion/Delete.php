<?php

namespace App\Http\Controllers\Frontend\Community\RecipeQuestion;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\RecipeQuestion;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\RecipeQuestion
 */
class Delete extends AbstractEdit
{
    /**
     * @param RecipeQuestion $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(RecipeQuestion $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
