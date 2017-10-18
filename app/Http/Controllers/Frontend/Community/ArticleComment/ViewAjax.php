<?php

namespace App\Http\Controllers\Frontend\Community\ArticleComment;

use App\Models\ArticleComment;
use Illuminate\Http\Request;

/**
 * Class ViewAjax
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class ViewAjax extends View
{
    /**
     * @param Request $request
     * @param ArticleComment $item
     * @return void
     */
    public function __invoke(Request $request, ArticleComment $item)
    {
        $this->item = $item;
        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        echo $this->getResultsJsonData($result, $parameters);
    }
}
