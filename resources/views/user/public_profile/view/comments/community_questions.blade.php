@if ($communityQuestions->count())
    <div class="js-community-questions-container js-hidden">
        <ul class="js-community-questions-list">
            @include('user.public_profile.view.comments.community_questions.items')
        </ul>
        @if ($communityQuestions->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-community-questions-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif