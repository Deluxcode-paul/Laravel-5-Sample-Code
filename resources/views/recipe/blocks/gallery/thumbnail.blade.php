<li class="swiper-slide">
    <img src="{{$slide->getImage('details.slide_thumbnail')}}" title="{{$recipe->title}}" />
    @if ($slide->isVideo())
        <span class="video-icon">
            <svg viewBox="0 0 100 100" class="icon icon-play">
                <use xlink:href="#icon-play"></use>
            </svg>
        </span>
    @endif
</li>