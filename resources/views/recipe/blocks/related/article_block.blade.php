<li class="item-related">
    <a href="{{ $article->getUrlAttribute() }}" class="item-related__visual">
        <img src="{{ $article->getListImageAttribute() }}" alt="{{ $article->title }}">
        @if ($article->videos->count() > 0)
            <span class="video">
                <svg viewBox="0 0 100 100" class="icon icon-play">
                    <use xlink:href="#icon-play"></use>
                </svg>
            </span>
        @endif
    </a>
    <div class="item-related__info">
        <a href="{{ $article->category()->getResults()->getUrl() }}" class="item-related__category uppercase">
            {{ $article->category()->getResults()->title }}
        </a>
        <h4 class="item-related__title"><a href="{{ $article->getUrlAttribute() }}">{{ $article->title }}</a></h4>
        <div class="item-related__descr">
            <p>{{ str_limit(strip_tags($article->content), 90) }}</p>
        </div>
    </div>
</li>