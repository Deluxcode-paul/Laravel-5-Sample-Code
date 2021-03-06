<?php

namespace App\Http\Controllers\Frontend\Community\ArticleComment;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Delete extends Controller
{
    /**
     * @param ArticleComment $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ArticleComment $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
