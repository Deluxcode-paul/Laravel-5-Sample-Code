<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Article\Share;

use App\Http\Controllers\Controller;
use App\Models\Article;

class GetPrint extends Controller
{
    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Article $article)
    {
        return view('pages.lifestyle.article.share.print', compact('article'));
    }
}
