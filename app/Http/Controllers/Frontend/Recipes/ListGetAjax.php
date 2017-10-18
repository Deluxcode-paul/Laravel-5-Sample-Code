<?php

namespace App\Http\Controllers\Frontend\Recipes;

use Illuminate\Http\Request;

/**
 * Class ListGetAjax
 * @package App\Http\Controllers\Frontend\Recipes
 */
class ListGetAjax extends ListGet
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
