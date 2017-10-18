<?php

namespace App\Http\Controllers\Frontend\Community\RecipeQuestion;

use App\Events\RecipeQuestion\RecipeQuestionViewed;
use App\Http\Controllers\Frontend\Community\AbstractDetails;
use App\Models\RecipeAnswer;
use App\Models\RecipeQuestion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Community\RecipeQuestion
 */
class View extends AbstractDetails
{
    /**
     * @param Request $request
     * @param RecipeQuestion $item
     * @return mixed
     */
    public function __invoke(Request $request, RecipeQuestion $item)
    {
        $this->item = $item;
        event(new RecipeQuestionViewed($this->item));

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

        return view('community.recipe_question.view', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = RecipeAnswer::where('recipe_question_id', $this->item->id);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
