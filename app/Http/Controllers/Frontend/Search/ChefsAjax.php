<?php

namespace App\Http\Controllers\Frontend\Search;

use Illuminate\Http\Request;

/**
 * Class ChefAjax
 * @package App\Http\Controllers\Frontend\Search
 */
class ChefsAjax extends Chefs
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
