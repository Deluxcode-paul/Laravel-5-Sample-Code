<?php

namespace App\Http\Controllers\Frontend\User\Profile\RecipeBox;

use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\User\Profile\RecipeBox
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
