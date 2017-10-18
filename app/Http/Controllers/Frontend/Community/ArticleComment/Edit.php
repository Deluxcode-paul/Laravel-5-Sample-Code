<?php

namespace App\Http\Controllers\Frontend\Community\ArticleComment;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\ArticleComment;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Edit extends AbstractEdit
{
    /**
     * @param ArticleComment $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ArticleComment $item)
    {
        $this->item = $item;

        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.article_comment.edit', $this->getTemplateVariables());
    }
}
