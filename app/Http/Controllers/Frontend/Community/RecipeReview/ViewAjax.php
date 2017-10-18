<?php

namespace App\Http\Controllers\Frontend\Community\RecipeReview;

use App\Models\Review;
use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\Community\RecipeReview
 */
class ViewAjax extends View
{
    /**
     * @param Request $request
     * @param Review $item
     * @return void
     */
    public function __invoke(Request $request, Review $item)
    {
        $this->item = $item;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
