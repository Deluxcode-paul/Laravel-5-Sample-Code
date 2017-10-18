<div class="watch__shows j-watch-slider">
    <div class="swiper-container">
        @if ($shows->count() > 1)
            <div class="swiper-wrapper">
                @foreach($shows as $show)
                    <a href="{{ $show->detailsUrl }}" class="swiper-slide item">
                        <img class="img" src="{{ $show->getCoverImage() }}" alt="{{ $show->title }}" />
                        <span class="title">{{ str_limit(strip_tags( $show->title ), 100) }}</span>
                    </a>
                @endforeach
            </div>
            <div class="watch__navigation">
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
            </div>
        @else
            <div class="swiper-wrapper">
                <a href="{{ $shows->first()->detailsUrl }}" class="swiper-slide swiper-slide-active item item--alone">
                    <img class="img" src="{{ $shows->first()->getCoverImage() }}" alt="{{ $shows->first()->title }}" />
                    <span class="title">{{ str_limit(strip_tags( $shows->first()->title ), 100) }}</span>
                </a>
            </div>
        @endif
    </div>
</div>