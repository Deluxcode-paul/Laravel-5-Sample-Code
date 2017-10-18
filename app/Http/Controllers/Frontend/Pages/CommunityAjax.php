<?php

namespace App\Http\Controllers\Frontend\Pages;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CommunityAjax
 * @package App\Http\Controllers\Frontend\Pages
 */
class CommunityAjax extends Community
{
    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
        $this->currentPage = LengthAwarePaginator::resolveCurrentPage();
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
