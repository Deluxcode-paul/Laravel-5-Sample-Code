@if ($recipeReviews->total())
    <div class="js-recipe-reviews-container js-hidden">
        <ul class="js-recipe-reviews-list">
            @include('user.public_profile.view.comments.recipe_reviews.items')
        </ul>
        @if ($recipeReviews->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-recipe-reviews-button"">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif