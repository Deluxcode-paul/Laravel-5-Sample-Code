<?php

namespace App\Http\Controllers\Frontend\Community\RecipeQuestion;

use App\Models\RecipeQuestion;
use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\Community\RecipeQuestion
 */
class ViewAjax extends View
{
    /**
     * @param Request $request
     * @param RecipeQuestion $item
     * @return void
     */
    public function __invoke(Request $request, RecipeQuestion $item)
    {
        $this->item = $item;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
