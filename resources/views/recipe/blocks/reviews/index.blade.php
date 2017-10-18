<div class="community-block__header">
    @if (empty($currentUser))
        <div class="community-block__notify">
            @lang('recipe/review.please') <a class="link" href="{{ url('login') . '?destination=' . urlencode($recipe->getUrl() . '#reviews') }}">
                @lang('recipe/review.log_in')
            </a> @lang('recipe/review.to_post_review')
            <span class="fake-input">@lang('recipe/review.write_review_placeholder')</span>
            <span class="fake-button">@lang('recipe/review.write_reviews_post')</span>
        </div>
    @else
        <button class="btn is-purple js-add-community" data-link="{{ route('recipe.reviews.edit', [$recipe->id, 0]) }}">
            @lang('recipe/review.write_reviews')
        </button>
        <div class="community-block__form js-community-edit-container" ></div>
    @endif
</div>

<div class="community-block__rating">
    <ul class="rating" data-rating="{{ $recipe->rating }}">
        <li>@include('partials.icons.icon-star')</li>
        <li>@include('partials.icons.icon-star')</li>
        <li>@include('partials.icons.icon-star')</li>
        <li>@include('partials.icons.icon-star')</li>
        <li>@include('partials.icons.icon-star')</li>
    </ul>
    <span>{{ $recipe->rating }} / 5 @lang('global.stars')</span>
</div>

<ul class="community-block__list js-reviews-list-container">
    @if ($recipe->reviews->count())
        @include('recipe.blocks.reviews.list')
    @endif
</ul>

@if ($reviewsPage->hasMorePages())
    <div class="community-block__footer actions a-center">
        <a href="{{ route('recipe.reviews.view', [$recipe->id]).  "?page=" . ($reviewsPage->currentPage() + 1) }}"
           data-container=".js-reviews-list-container"
           data-error="@lang('recipe/review.error_update_review')"
           class="btn is-purple js-load-more-button"
        >
            @lang('user/profile.buttons.load_more')
        </a>
    </div>
@endif