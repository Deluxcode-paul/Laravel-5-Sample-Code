<li class="item-community js-community-{{ $review->id }}">
    <div class="item-community__wrapper">
        <div class="item-community__photo">
            <a href="{{ $review->user->publicProfileUrl }}">
                <img src="{{ $review->user->getImage('user_activity') }}" alt="{{ $review->user->fullName }}">
            </a>
        </div>
        <div class="item-community__content">
            <ul class="rating js-review-rating-{{ $review->id }}" data-value="{{ $review->rating }}"
                data-rating="{{ $review->rating }}">
                <li>@include('partials.icons.icon-star')</li>
                <li>@include('partials.icons.icon-star')</li>
                <li>@include('partials.icons.icon-star')</li>
                <li>@include('partials.icons.icon-star')</li>
                <li>@include('partials.icons.icon-star')</li>
            </ul>
            <h3 class="title js-review-title-{{ $review->id }}">
                <a href="{{ $review->detailsUrl }}">
                    {!! $review->title !!}
                </a>
            </h3>
            <div class="descr js-review-detail-{{ $review->id }}">{!! $review->details !!}</div>
            <div class="author">
                {{ $review->user->fullName }} | <span>{{ $review->publishedAt }}</span>
            </div>
            @if ($review->tags->count() > 0)
                <div class="tags">
                    <ul>
                        @foreach($review->tags as $tag)
                            <li>
                                <a href="{{ $tag->сommunitySearchUrl }}" title="{{ $tag->title }}">{{ $tag->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($review->chefs->count() > 0)
                <div class="chefs">
                    <ul>
                        @foreach($review->chefs as $chef)
                            <li>
                                <a href="{{ $chef->publicProfileUrl }}"
                                   title="{{ $chef->fullName }}">{{ $chef->fullName }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="item-community__meta">
        <div class="item-community__info">
            <div class="item">
                @include('partials.icons.icon-heart')
                <span>{!! $review->votes !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-view')
                <span>{!! $review->views !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-comment')
                <span>{!! $review->comments()->count() !!}</span>
            </div>
        </div>
        <div class="item-community__actions">
            @can('edit', $review)
                {{-- TODO: implement edit functionality --}}
                <a class="link js-community-edit" href="{{ $review->editUrl }}">
                    @lang('recipe/review.review_edit')
                </a>
            @endcan
            @can('report', $review)
                <a class="link js-report-abuse"
                   data-id="{{ $review->id }}"
                   data-type="recipe-review"
                   data-link="{{ route('user.profile.activity.report-abuse')}}"
                   href="#">
                    @lang('recipe/review.review_abuse')
                </a>
            @endcan
        </div>
    </div>
</li>


