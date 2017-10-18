<div class="chef__subnav">
    <ul>
        @if ($recipeQuestions->total())
        <li>
            <a href="#" class="js-recipe-questions-button">
                @lang('user/profile.activity.recipe_questions')
            </a>
        </li>
        @endif
        @if ($recipeReviews->total())
        <li>
            <a href="#" class="js-recipe-reviews-button">
                @lang('user/profile.activity.recipe_reviews')
            </a>
        </li>
        @endif
        @if ($articleComments->count())
        <li>
            <a href="#" class="js-article-comments-button">
                @lang('user/profile.activity.article_comments')
            </a>
        </li>
        @endif
        @if ($communityQuestions->count())
        <li>
            <a href="#" class="js-community-questions-button">
                @lang('user/profile.activity.community_questions')
            </a>
        </li>
        @endif
    </ul>
</div>
