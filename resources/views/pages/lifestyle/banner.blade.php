<div class="lifestyle-page__slider j-lifestyle-slider">
    <div class="swiper-container">
    @if ($bannerArticles->count() > 1)
        <div class="swiper-wrapper">
            @foreach($bannerArticles as $article)
            <div class="swiper-slide item">
{{--                 @if ($article->icon == 'top_chef')
                    <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                @elseif ($article->icon == 'community_chef')
                    <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                @endif --}}
                <a href="{{ $article->url }}" class="img" style="background-image: url('{{ $article->getImage('article_banner') }}');"></a>
                <div class="content">
                    <span class="category">@lang('pages/lifestyle.labels.featured_article')</span>
                    <a href="{{ $article->url }}" class="title">{{ $article->title }}</a>
                    <div class="desc">
                        {{ str_limit(strip_tags($article->content), 120) }}
                    </div>
                    <div class="meta">
                        <span>{{ $article->published }}</span> |
                        <a href="{{ $article->user->publicProfileUrl }}">
                            {{ $article->user->fullName }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="lifestyle-page__navigation">
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
    @else
        <div class="swiper-wrapper">
            <div class="swiper-slide item swiper-slide-active">
{{--                 @if ($article->icon == 'top_chef')
                    <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                @elseif ($article->icon == 'community_chef')
                    <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                @endif --}}
                <a href="{{ $bannerArticles->first()->url }}" class="img" style="background-image: url('{{ $bannerArticles->first()->getImage('article_banner') }}');"></a>
                <div class="content">
                    <span class="category">@lang('pages/lifestyle.labels.featured_article')</span>
                    <a href="{{ $bannerArticles->first()->url }}" class="title">{{ $bannerArticles->first()->title }}</a>
                    <div class="desc">
                        {{ str_limit(strip_tags($bannerArticles->first()->content), 120) }}
                    </div>
                    <div class="meta">
                        <span>{{ $bannerArticles->first()->published }}</span> |
                        <a href="{{ $bannerArticles->first()->user->publicProfileUrl }}">
                            {{ $bannerArticles->first()->user->fullName }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>