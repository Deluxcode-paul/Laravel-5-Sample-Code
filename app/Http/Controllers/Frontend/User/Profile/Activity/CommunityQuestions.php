<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity;

use App\Models\GeneralQuestion;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CommunityQuestions
 * @package App\Http\Controllers\Frontend\User\Profile\Activity
 */
class CommunityQuestions extends AbstractActivity
{
    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('user/profile'));

        return view('user.profile.activity.community_questions', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = GeneralQuestion::forUser($this->currentUser->id)->orderBy('updated_at', 'desc');
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
