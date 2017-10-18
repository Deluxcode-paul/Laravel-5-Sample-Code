<?php

namespace App\Http\Controllers\Frontend\Pages\Lifestyle;

use App\Models\Article;
use App\Http\Controllers\Controller;
use Assets;
use App\Events\Article\ArticleViewed;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\Pages\Lifestyle
 */
class View extends Controller
{
    /**
     * @var Article $article
     */
    protected $article;

    /**
     * Controller main action
     * @param \App\Models\Article $article
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Article $article, $slug = '')
    {
        if (empty($slug)) {
            return redirect()->to($article->getUrl());
        }

        $this->article = $article;

        $relatedArticles = $this->getRelatedArticles();

        $commentsPage = $article->getCommentsPage();

        Assets::group('frontend')->addJs('share/print.js');
        Assets::group('frontend')->addJs('share/social.js');
        Assets::group('frontend')->addJs('share/email.js');
        Assets::group('frontend')->addJs('pages/article.js');
        Assets::group('frontend')->addJs('user/profile/activity.js');

        event(new ArticleViewed($this->article));

        return view('pages.lifestyle.article', compact(
            'article',
            'relatedArticles',
            'commentsPage'
        ));
    }

    /**
     * Return related articles
     * @return mixed
     */
    protected function getRelatedArticles()
    {
        $related = Article::published()
            ->related($this->article)
            ->random()
            ->take(config('kosher.pagination.article_related'))
            ->get();

        if ($related->count() < config('kosher.pagination.article_related')) {
            $general = Article::published()
                ->random()
                ->whereNotIn('id', $related->pluck('id')->merge([$this->article->id]))
                ->take((config('kosher.pagination.article_related') - $related->count()))
                ->get();

            $related = $related->merge($general);
        }

        return $related->shuffle();
    }
}
