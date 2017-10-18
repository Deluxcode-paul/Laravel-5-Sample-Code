<li class="item-community js-community-{{ $question->id }}">
    <div class="item-community__wrapper">
        <div class="item-community__photo">
            <a href="{{ $question->user->publicProfileUrl }}">
                <img src="{{ $question->user->getImage('user_activity') }}" alt="{{ $question->user->fullName }}">
            </a>
        </div>
        <div class="item-community__content">
            <h3 class="title js-review-title-{{ $question->id }}">
                <a href="{{ $question->detailsUrl }}">
                    {!! $question->title !!}
                </a>
            </h3>
            <div class="descr js-review-detail-{{ $question->id }}">{!! $question->details !!}</div>
            <div class="author">
                {{ $question->user->fullName }} | <span>{{ $question->publishedAt }}</span>
            </div>
            @if ($question->tags->count() > 0)
                <div class="tags">
                    <ul>
                        @foreach($question->tags as $tag)
                            <li>
                                <a href="{{ $question->getSearchUrl($tag->title) }}" title="{{ $tag->title }}">{{ $tag->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($question->chefs->count() > 0)
                <div class="chefs">
                    <ul>
                        @foreach($question->chefs as $chef)
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
                <span>{!! $question->votes !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-view')
                <span>{!! $question->views !!}</span>
            </div>
            <div class="item">
                @include('partials.icons.icon-comment')
                <span>{!! $question->answers()->count() !!}</span>
            </div>
        </div>
        <div class="item-community__actions">
            @can('edit', $question)
                {{-- TODO: implement edit functionality --}}
                <a
                        class="link js-community-edit"
                        href="{{$question->editUrl}}"
                >
                    @lang('recipe/questions.question_edit')
                </a>
            @endcan
            @can('report', $question)
                <a class="link js-report-abuse"
                   data-id="{{ $question->id }}"
                   data-type="recipe-review"
                   data-link="{{ route('user.profile.activity.report-abuse')}}"
                   href="#">
                    @lang('recipe/question.question_abuse')
                </a>
            @endcan
        </div>
    </div>
</li>