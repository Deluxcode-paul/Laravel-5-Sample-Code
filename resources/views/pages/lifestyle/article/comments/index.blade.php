<ul class="tabset uppercase">
    <li><a href="#comments">@lang('pages/comments.comments_title')</a></li>
</ul>

<div id="comments">
    <div class="community-block__header">
        @if (empty($currentUser))
            <div class="community-block__notify">
                @lang('pages/comments.please') <a class="link" href="{{ url('login') . '?destination=' . urlencode($article->getUrl() . '#comments') }}">
                    @lang('pages/comments.log_in')
                </a> @lang('pages/comments.to_write_comment')
                <span class="fake-input">@lang('pages/comments.write_comment_placeholder')</span>
                <span class="fake-button">@lang('pages/comments.write_comment_post')</span>
            </div>
        @else
            <button class="btn is-purple js-add-community" data-link="{{ route('article-comments.edit', [$article->id, 0]) }}">
                @lang('pages/comments.write_comment')
            </button>
            <div class="community-block__form js-community-edit-container"></div>
        @endif
    </div>

    <ul class="community-block__list js-comments-list-container">
        @if ($commentsPage->count())
            @include('pages.lifestyle.article.comments.list')
        @endif
    </ul>

    @if ($commentsPage->hasMorePages())
        <div class="actions a-center">
            <a href="{{ route('article-comments.view', [$article->id]).  "?page=" . ($commentsPage->currentPage() + 1) }}"
               data-container=".js-comments-list-container"
               data-error="@lang('pages/comments.error_update_comment')"
               class="btn is-purple js-load-more-button"
            >
                @lang('user/profile.buttons.load_more')
            </a>
        </div>
    @endif
</div>


