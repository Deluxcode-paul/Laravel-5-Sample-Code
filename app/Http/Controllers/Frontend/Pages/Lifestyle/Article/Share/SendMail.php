<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle\Article\Share;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Article;
use App\Http\Requests\Frontend\Pages\Lifestyle\Article\ArticleEmailRequest;
use App\Mail\SendArticle;

class SendMail extends Controller
{
    /**
     * @param ArticleEmailRequest $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ArticleEmailRequest $request, Article $article)
    {
        Mail::to($request->get('email'))->send(new SendArticle($article));

        return response()->json(['message' => trans('share.mail_to_already_sent'), 'type'=>'success']);
    }
}
