<section class="lifestyle" style="background-image: url('{{ url('images/home/bg-lifestyle.jpg') }}');">
    <div class="site-width">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('pages/home.headings.explore')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.lifestyle')</h3>
        </div>
        <div class="lifestyle__container">
            <div class="lifestyle__column">
                @if ($mainArticle->count())
                    <div class="lifestyle__article">
                        <a href="{{ $mainArticle->url }}" class="lifestyle__img">
                            <img src="{{ $mainArticle->getImage('article_home_page_big') }}">
                            @if ($mainArticle->videos->count() > 0)
                                <span class="video">
                                    <svg viewBox="0 0 100 100" class="icon icon-play">
                                        <use xlink:href="#icon-play"></use>
                                    </svg>
                                </span>
                            @endif
                        </a>
                        <div class="lifestyle__content">
                            <div class="head">
                                <a class="category" href="{{ $mainArticle->getCategoryUrl() }}">
                                    {{ $mainArticle->category->title }}
                                </a>
                            </div>
                            <a class="title" href="{{ $mainArticle->url }}">{{ str_limit($mainArticle->title, 37) }}</a>
                            <div class="desc">{{ str_limit(strip_tags($mainArticle->content), 150) }}</div>
                            <div  class="lifestyle__meta">
                                <span>{{ $mainArticle->published }}</span> |
                                <a href="{{ $mainArticle->user->publicProfileUrl }}">
                                    {{ $mainArticle->user->fullName }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="lifestyle__column">
                @if ($articles->count())
                    <ul>
                        @foreach($articles as $article)
                            @include('pages.home.explore_lifestyle.article')
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="a-center actions">
            <a class="btn is-purple" href="{{ route('lifestyle') }}"><p>@lang('pages/home.buttons.view_all_articles')</p></a>
        </div>
    </div>
</section>