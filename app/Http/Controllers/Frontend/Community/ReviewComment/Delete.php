<?php

namespace App\Http\Controllers\Frontend\Community\ReviewComment;

use App\Http\Controllers\Controller;
use App\Models\ReviewComment;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Delete extends Controller
{
    /**
     * @param ReviewComment $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(ReviewComment $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
