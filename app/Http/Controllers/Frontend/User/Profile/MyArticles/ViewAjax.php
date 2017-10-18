<?php

namespace App\Http\Controllers\Frontend\User\Profile\MyArticles;

use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\User\Profile\MyArticles
 */
class ViewAjax extends View
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
