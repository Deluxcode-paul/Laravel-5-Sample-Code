<?php

namespace App\Http\Controllers\Frontend\Community\RecipeReview;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\Review;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\RecipeReview
 */
class Delete extends AbstractEdit
{

    /**
     * @param Review $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Review $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
