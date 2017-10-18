<li class="item-community">
    <div class="item-community__wrapper">
        <div class="item-community__photo">
            <a href="{{ $item->user->publicProfileUrl }}">
                <img src="{{ $item->user->activityImage }}" alt="{{ $item->user->fullName }}">
            </a>
        </div>
        <div class="item-community__content">
            @if ($item->hasRating)
                <ul class="rating" data-rating="{{ $item->rating }}">
                    <li>@include('partials.icons.icon-star')</li>
                    <li>@include('partials.icons.icon-star')</li>
                    <li>@include('partials.icons.icon-star')</li>
                    <li>@include('partials.icons.icon-star')</li>
                    <li>@include('partials.icons.icon-star')</li>
                </ul>
            @endif
            <h3 class="title">
                <a href="{{ $item->detailsUrl }}">
                    {{ $item->title }}
                </a>
            </h3>
            <div class="descr">{{ $item->details }}</div>
            <div class="author">
                @lang('community.posted_by')
                <a href="{{ $item->user->publicProfileUrl }}">{{ $item->user->fullName }}</a>
                | <span>{{ $item->publishedAt }}</span>
            </div>
            @if ($item->tags)
                <ul class="tags">
                    @foreach ($item->tags as $tag)
                        <li><a href="{{ $tag->communitySearchUrl }}">{{ $tag->title }}</a></li>
                    @endforeach
                </ul>
            @endif
            @if ($item->chefs)
                <ul class="chefs">
                    @foreach ($item->chefs as $chef)
                        <li><a href="{{ $chef->publicProfileUrl }}">{{ $chef->fullName }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="item-community__meta">
        <div class="item-community__info">
            @can('vote', $item)
                <a class="item js-vote"
                   data-id="{{ $item->id }}"
                   data-type="{{ $item->dataType }}"
                   href="#">
                    @include('partials.icons.icon-heart')
                    <span>{{ $item->votes }}</span>
                </a>
            @endcan
            @cannot('vote', $item)
                @include('community.json_blocks.vote', ['votes' => $item->votes])
            @endcannot
            <a class="item" href="{{ $item->detailsUrl.'#replies' }}">
                @include('partials.icons.icon-comment')
                <span>{{ $item->replies }}</span>
            </a>
        </div>
        <div class="item-community__actions">
            @can('edit', $item)
                <a class="link" href="{{ $item->editUrl }}">@lang('user/profile.activity.edit')</a>
            @endcan
        </div>
    </div>
</li>