<div class="community-block__header">
    @if (empty($currentUser))
        <div class="community-block__notify">
            @lang('recipe/questions.please') <a class="link" href="{{ url('login') . '?destination=' . urlencode($recipe->getUrl() . '#questions') }}">
                @lang('recipe/questions.log_in')
            </a> @lang('recipe/questions.to_ask_question')
            <span class="fake-input">@lang('recipe/questions.write_question_placeholder')</span>
            <span class="fake-button">@lang('recipe/questions.write_question_post')</span>
        </div>
    @else
        <button class="btn is-purple js-add-community" data-link="{{ route('recipe.questions.edit', [$recipe->id, 0]) }}">
            @lang('recipe/questions.write_question')
        </button>
        <div class="community-block__form js-community-edit-container"></div>
    @endif
</div>

<ul class="community-block__list js-questions-list-container">
    @if ($recipe->reviews->count())
        @include('recipe.blocks.questions.list')
    @endif
</ul>

@if ($reviewsPage->hasMorePages())
    <div class="community-block__footer actions a-center">
        <a href="{{ route('recipe.questions.view', [$recipe->id]).  "?page=" . ($reviewsPage->currentPage() + 1) }}"
           data-container=".js-questions-list-container"
           data-error="@lang('recipe/questions.error_update_question')"
           class="btn is-purple js-load-more-button"
        >
            @lang('user/profile.buttons.load_more')
        </a>
    </div>
@endif