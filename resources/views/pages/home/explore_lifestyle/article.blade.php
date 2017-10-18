<li class="lifestyle__article lifestyle__article--small">
    <a href="{{ $article->url }}" class="lifestyle__img">
        <img src="{{ $article->getImage('article_home_page_small') }}">
        @if ($article->videos->count() > 0)
            <span class="video">
                <svg viewBox="0 0 100 100" class="icon icon-play">
                    <use xlink:href="#icon-play"></use>
                </svg>
            </span>
        @endif
    </a>
    <div class="lifestyle__content">
        <div class="head">
            <a class="category" href="{{ $article->getCategoryUrl() }}">
                {{ $article->category->title }}
            </a>
        </div>
        <a class="title" href="{{ $article->url }}">{{ str_limit($article->title, 60) }}</a>
        <div  class="lifestyle__meta">
            <span>{{ $article->published }}</span> |
            <a href="{{ $article->user->publicProfileUrl }}">
                {{ $article->user->fullName }}
            </a>
        </div>
    </div>
</li>