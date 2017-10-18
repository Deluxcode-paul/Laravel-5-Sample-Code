<li class="item-community js-community-{{ $comment->id }}">
    <div class="item-community__wrapper">
        <div class="item-community__photo">
            <a href="{{ $comment->user->publicProfileUrl }}">
                <img src="{{ $comment->user->getImage('user_activity') }}" alt="{{ $comment->user->fullName }}">
            </a>
        </div>
        <div class="item-community__content">
            <h3 class="title js-review-title-{{ $comment->id }}">
                <a href="{{ $comment->detailsUrl }}">
                    {!! $comment->title !!}
                </a>
            </h3>
            <div class="descr js-review-detail-{{ $comment->id }}">{!! $comment->details !!}</div>
            <div class="author">
                {{ $comment->user->fullName }} | <span>{{ $comment->publishedAt }}</span>
            </div>
            @if ($comment->tags->count() > 0)
                <div class="tags">
                    <ul>
                        @foreach($comment->tags as $tag)
                            <li><a href="{{ $comment->getSearchUrl($tag->title) }}" title="{{ $tag->title }}">{{ $tag->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($comment->chefs->count() > 0)
                <div class="chefs">
                    <ul>
                        @foreach($comment->chefs as $chef)
                            <li><a href="{{ $chef->publicProfileUrl }}" title="{{ $chef->fullName }}">{{ $chef->fullName }}</a></li>
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
                <span>{!! $comment->votes !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-view')
                <span>{!! $comment->views !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-comment')
                <span>{!! $comment->replies !!}</span>
            </div>
        </div>
        <div class="item-community__actions">
            @can('edit', $comment)
                <a class="link" href="{{ $comment->editUrl }}#">@lang('pages/comments.comment_edit')</a>
            @endcan
            @can('report', $comment)
                <a class="link js-report-abuse"
                   data-id="{{ $comment->id }}"
                   data-type="recipe-review"
                   data-link="{{ route('user.profile.activity.report-abuse')}}"
                   href="#">
                    @lang('pages/comments.comment_abuse')
                </a>
            @endcan
        </div>
    </div>
</li>