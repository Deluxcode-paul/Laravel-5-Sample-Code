<?php

namespace App\Http\Controllers\Frontend\Community\ReviewComment;

use App\Http\Controllers\Controller;
use App\Models\ReviewComment;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Edit extends Controller
{
    /**
     * @param ReviewComment $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ReviewComment $item)
    {
        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.review_comment.edit', compact('item'));
    }
}
