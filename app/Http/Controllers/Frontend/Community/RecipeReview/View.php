<?php

namespace App\Http\Controllers\Frontend\Community\RecipeReview;

use App\Events\RecipeReview\RecipeReviewViewed;
use App\Http\Controllers\Frontend\Community\AbstractDetails;
use App\Models\Review;
use App\Models\ReviewComment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Community\RecipeReview
 */
class View extends AbstractDetails
{
    /**
     * @param Request $request
     * @param Review $item
     * @return mixed
     */
    public function __invoke(Request $request, Review $item)
    {
        $this->item = $item;
        event(new RecipeReviewViewed($this->item));

        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
            'item' => $this->item
        ]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('community'));

        return view('community.recipe_review.view', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = ReviewComment::where('review_id', $this->item->id);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
