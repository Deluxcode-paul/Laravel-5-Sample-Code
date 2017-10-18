<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity;

use Illuminate\Http\Request;

/**
 * Class ArticleCommentsAjax
 * @package App\Http\Controllers\Frontend\User\Profile\Activity
 */
class ArticleCommentsAjax extends ArticleComments
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
