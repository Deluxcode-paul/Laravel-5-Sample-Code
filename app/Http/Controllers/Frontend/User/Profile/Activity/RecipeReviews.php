<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity;

use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RecipeReviews
 * @package App\Http\Controllers\Frontend\User\Profile\Activity
 */
class RecipeReviews extends AbstractActivity
{
    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('user/profile'));

        return view('user.profile.activity.recipe_reviews', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = Review::forUser($this->currentUser->id)->orderBy('updated_at', 'desc');
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
