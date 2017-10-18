<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity;

use Illuminate\Http\Request;

/**
 * Class RecipeQuestionsAjax
 * @package App\Http\Controllers\Frontend\User\Profile\Activity
 */
class RecipeQuestionsAjax extends RecipeQuestions
{
    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
