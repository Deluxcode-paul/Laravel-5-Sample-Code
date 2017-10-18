@if ($recipeQuestions->total())
    <div class="js-recipe-questions-container">
        <ul class="js-recipe-questions-list">
            @include('user.public_profile.view.comments.recipe_questions.items')
        </ul>
        @if ($recipeQuestions->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-recipe-questions-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif