<section class="aside__section">
    <h2 class="title">@lang('community.headings.most_popular')</h2>
    <ul class="popular">
        @foreach ($popularItems as $item)
            <li class="popular__item">
                <div class="wrap">
                    <a class="img "href="{{ $item->user->publicProfileUrl }}">
                        <img src="{{ $item->user->activityImage }}" alt="{{ $item->user->fullName }}">
                    </a>
                    <div class="desc">
                        <a href="{{ $item->detailsUrl }}">
                            {{ $item->title }}
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</section>