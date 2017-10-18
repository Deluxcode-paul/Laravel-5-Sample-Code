<?php

namespace App\Http\Controllers\Frontend\Community\ArticleComment;

use App\Events\ArticleComment\ArticleCommentViewed;
use App\Http\Controllers\Frontend\Community\AbstractDetails;
use App\Models\ArticleComment;
use App\Models\ArticleReply;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class View extends AbstractDetails
{
    /**
     * @param Request $request
     * @param ArticleComment $item
     * @return mixed
     */
    public function __invoke(Request $request, ArticleComment $item)
    {
        $this->item = $item;
        event(new ArticleCommentViewed($this->item));

        $this->readInputVars($request);
        $parameters = $this->calculateParameters();
        $result = $this->getResult();

        return $this->render([
            'currentUrl' => \Request::url(),
            'results' => $this->getResultsJsonData($result, $parameters),
            'item' => $this->item
        ]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($data)
    {
        $data['labels'] = array_merge(trans('search/common'), trans('community'));

        return view('community.article_comment.view', $data);
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        /** @var Builder $query */
        $query = ArticleReply::where('article_comment_id', $this->item->id);
        $this->applyParametersToQuery($query);

        return $query->distinct();
    }
}
