@foreach($videos as $video)
<li class="item-recipe">
    <a href="{{ $video->detailsUrl }}" class="item-recipe__wrapper">
        <div class="item-recipe__visual">
            <span class="item-recipe__video">
                <svg viewBox="0 0 100 100" class="icon icon-play">
                    <use xlink:href="#icon-play"></use>
                </svg>
            </span>
            <img src="{{ $video->listImage}}" class="item-recipe__img" alt="{{ $video->title }}" width="285" height="215" />
        </div>
        <h4 class="item-recipe__title">{{ $video->title }}</h4>
    </a>
    <div class="item-recipe__meta">
        <a href="#" class="item-recipe__author">
            {{ $video->creator }}
        </a>
    </div>
</li>
@endforeach

