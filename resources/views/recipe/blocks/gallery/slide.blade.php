<li class="swiper-slide">
    @if ($gallery->count() == 1)
        <div class="gallery-top__img" style="background-image: url('{{ $slide->getImage('details.slide') }}');"></div>
    @else
        <div class="gallery-top__img swiper-lazy" data-background="{{ $slide->getImage('details.slide') }}">
        </div>
        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
    @endif
    @if ($slide->isVideo())
        <a href="{{ $slide->getDetailPageUrl() }}" class="link-video">
            <span class="video-icon">
                <svg viewBox="0 0 100 100" class="icon icon-play">
                    <use xlink:href="#icon-play"></use>
                </svg>
            </span>
        </a>
    @endif
</li>