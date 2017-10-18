<?php

namespace App\Http\Controllers\Frontend\Community\ArticleReply;

use App\Http\Controllers\Controller;
use App\Models\ArticleReply;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Edit extends Controller
{
    /**
     * @param ArticleReply $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ArticleReply $item)
    {
        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.article_reply.edit', compact('item'));
    }
}
