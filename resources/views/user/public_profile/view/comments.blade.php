@if ($articleComments->count() || $communityQuestions->count() || $recipeQuestions->total() || $recipeReviews->total())
    <div class="chef__bookmark chef__comments js-comments-container" id="comments">
        @include('user.public_profile.view.comments.sections')

        @include('user.public_profile.view.comments.recipe_questions')
        @include('user.public_profile.view.comments.recipe_reviews')
        @include('user.public_profile.view.comments.article_comments')
        @include('user.public_profile.view.comments.community_questions')
    </div>
@endif