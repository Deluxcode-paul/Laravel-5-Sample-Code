<?php

namespace App\Http\Controllers\Frontend\Community\ArticleComment;

use App\Http\Controllers\Frontend\Community\AbstractSave;
use App\Http\Requests\Frontend\Community\ArticleCommentRequest;
use App\Models\ArticleComment;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Save extends AbstractSave
{
    /**
     * @param ArticleCommentRequest $request
     * @param ArticleComment $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(ArticleCommentRequest $request, ArticleComment $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
