<div class="watch__gallery j-watch-gallery">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($bannerVideos as $video)
                <div class="swiper-slide item">
                    <a href="{{ $video->detailsUrl }}" class="img" style="background-image: url('{{ $video->getImage('video_banner') }}');">
                        <div class="site-width">
                            @if ($video->icon == 'top_chef')
                                <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                            @elseif ($video->icon == 'community_chef')
                                <img src="/images/ribbon-recipe.png" alt="" class="ribbon" />
                            @endif
                        </div>
                    </a>
                    <div class="site-width">
                        <div class="container">
                            <div class="content">
                                <span class="category">@lang('pages/watch.labels.featured_video')</span>
                                <a href="{{ $video->detailsUrl }}" class="title">{{ $video->title }}</a>
                                <div class="desc">
                                    {{ str_limit(strip_tags( $video->description ), 120) }}
                                </div>
                                <div class="meta">
                                    <span>{{ $video->type }}</span> |
                                    <a href="{{ $video->creatorUrl }}">
                                        {{ $video->creator }}
                                    </a>
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($bannerVideos->count() > 1)
            <div class="watch__navigation">
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
            </div>
        @endif
    </div>
</div>