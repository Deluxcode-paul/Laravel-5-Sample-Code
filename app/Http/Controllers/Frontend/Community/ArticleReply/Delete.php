<?php

namespace App\Http\Controllers\Frontend\Community\ArticleReply;

use App\Http\Controllers\Controller;
use App\Models\ArticleReply;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Delete extends Controller
{
    /**
     * @param ArticleReply $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ArticleReply $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
