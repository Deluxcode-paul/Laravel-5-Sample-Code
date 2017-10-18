<?php

namespace App\Http\Controllers\Frontend\Pages\Watch;

use App\Models\Show;
use Illuminate\Http\Request;

/**
 * Class ShowLandingAjax
 * @package App\Http\Controllers\Frontend\Pages\Watch
 */
class ShowLandingAjax extends ShowLanding
{
    /**
     * @param Request $request
     * @param Show $show
     * @return void
     */
    public function __invoke(Request $request, Show $show)
    {
        $this->show = $show;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
