<?php

namespace App\Http\Controllers\Frontend\Community\ReviewComment;

use App\Http\Controllers\Frontend\Community\AbstractReplySave;
use App\Http\Requests\Frontend\Community\ReviewCommentRequest;
use App\Models\ReviewComment;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\RecipeAnswer
 */
class Save extends AbstractReplySave
{
    /**
     * @param ReviewCommentRequest $request
     * @param ReviewComment $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(ReviewCommentRequest $request, ReviewComment $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
