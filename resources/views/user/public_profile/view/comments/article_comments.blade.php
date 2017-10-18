@if ($articleComments->count())
    <div class="js-article-comments-container js-hidden">
        <ul class="js-article-comments-list">
            @include('user.public_profile.view.comments.article_comments.items')
        </ul>
        @if ($articleComments->hasMorePages())
            <a href="#" class="js-load-article-comments-button">@lang('user/profile.buttons.load_more')</a>
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-article-comments-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif