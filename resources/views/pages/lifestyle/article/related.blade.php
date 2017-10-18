<section class="aside__section">
    <h2 class="title">@lang('pages/article.headings.related_articles')</h2>
    <div class="related-articles">
        @foreach ($relatedArticles as $article)
            <a class="related-articles__item" href="{{ $article->url }}">
                <div class="desc">
                    <div class="img">
                        <img src="{{ $article->getImage('article_related') }}" />
                        @if ($article->videos->count() > 0)
                            <span class="video">
                                <svg viewBox="0 0 100 100" class="icon icon-play">
                                    <use xlink:href="#icon-play"></use>
                                </svg>
                            </span>
                        @endif
                    </div>
                    <h3>{{ $article->title }}</h3>
                </div>
            </a>
        @endforeach
    </div>
</section>