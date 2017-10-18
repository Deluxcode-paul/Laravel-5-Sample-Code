<?php

namespace App\Http\Controllers\Frontend\Community\ArticleReply;

use App\Http\Controllers\Frontend\Community\AbstractReplySave;
use App\Http\Requests\Frontend\Community\ArticleReplyRequest;
use App\Models\ArticleReply;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\ArticleReply
 */
class Save extends AbstractReplySave
{
    /**
     * @param ArticleReplyRequest $request
     * @param ArticleReply $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(ArticleReplyRequest $request, ArticleReply $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
