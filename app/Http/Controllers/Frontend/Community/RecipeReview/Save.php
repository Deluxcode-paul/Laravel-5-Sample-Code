<?php

namespace App\Http\Controllers\Frontend\Community\RecipeReview;

use App\Http\Controllers\Frontend\Community\AbstractSave;
use App\Http\Requests\Frontend\Community\RecipeReviewRequest;
use App\Models\Review;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\RecipeReview
 */
class Save extends AbstractSave
{
    /**
     * @param RecipeReviewRequest $request
     * @param Review $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(RecipeReviewRequest $request, Review $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->item->rating = $this->request->get('rating');
        $this->save();

        return redirect()->route('community');
    }
}
