<?php

namespace App\Http\Controllers\Frontend\Pages;

use Illuminate\Http\Request;

/**
 * Class LifestyleAjax
 * @package App\Http\Controllers\Frontend\Pages
 */
class LifestyleAjax extends Lifestyle
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
