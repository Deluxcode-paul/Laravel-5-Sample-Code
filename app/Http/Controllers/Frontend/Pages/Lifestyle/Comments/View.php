<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Comments;

use App\Http\Controllers\Controller;
use App\Models\Article;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Http\Request;

class View extends Controller
{
    /**
     * @param $articleId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($articleId, Request $request)
    {
        $message = trans('pages/comments.error_update_comment');
        $content = '';
        $hasMorePages = '';
        $link ='';
        try {
            $article = Article::find($articleId);
            $commentsPage = $article->getCommentsPage();
            $content = view('pages.lifestyle.article.comments.list', compact('commentsPage'))->render();
            $hasMorePages = $commentsPage->hasMorePages();
            $link = route('article-comments.view', [$articleId]).  "?page=" . ($commentsPage->currentPage() + 1);
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(compact('content', 'hasMorePages', 'message', 'link'));
    }
}
