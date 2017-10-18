<?php

namespace App\Http\Controllers\Frontend\Community\GeneralQuestion;

use App\Events\GeneralQuestion\GeneralQuestionViewed;
use App\Http\Controllers\Frontend\Community\AbstractDetails;
use App\Models\GeneralAnswer;
use App\Models\GeneralQuestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Community\GeneralQuestion
 */
class View extends AbstractDetails
{
    /**
     * @param Request $request
     * @param GeneralQuestion $item
     * @return mixed
     */
    public function __invoke(Request $request, GeneralQuestion $item)
    {
        $this->item = $item;
        event(new GeneralQuestionViewed($this->item));

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

        return view('community.community_question.view', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = GeneralAnswer::where('question_id', $this->item->id);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
