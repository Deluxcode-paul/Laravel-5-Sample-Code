<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Article\Share;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Events\Article\ArticleShared;

class Share extends Controller
{
    /**
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Article $article)
    {
        event(new ArticleShared($article));

        return response()->json(['message' => trans('share.shared_success'), 'type'=>'success']);
    }
}
