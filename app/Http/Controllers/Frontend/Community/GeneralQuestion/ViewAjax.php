<?php

namespace App\Http\Controllers\Frontend\Community\GeneralQuestion;

use App\Models\GeneralQuestion;
use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\Community\GeneralQuestion
 */
class ViewAjax extends View
{
    /**
     * @param Request $request
     * @param GeneralQuestion $item
     * @return void
     */
    public function __invoke(Request $request, GeneralQuestion $item)
    {
        $this->item = $item;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
