<?php

namespace App\Http\Controllers\Frontend\Pages;

use Illuminate\Http\Request;

/**
 * Class GenerateMealAjax
 * @package App\Http\Controllers\Frontend\Pages
 */
class GenerateMealAjax extends GenerateMeal
{
    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        if (empty($this->parameters)) {
            $result = null;
        } else {
            $result = $this->getResult();
        }

        echo $this->getResultsJsonData($result, $parameters);
    }
}
