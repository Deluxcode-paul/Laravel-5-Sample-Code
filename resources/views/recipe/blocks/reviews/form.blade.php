{{ Form::open([
       'method'=>'POST',
       'url' => $review->id
               ? route('recipe.reviews.save', [$review->recipe_id, $review->id])
               : route('recipe.reviews.add',[$review->recipe_id]),
       'class' => 'form form-grey form-community'
   ]) }}

{{ Form::hidden('id', $review->id, ['class' => 'js-form-hidden-id']) }}

<div class="form-row">
    <div class="form-item">
        <label class="form-label">@lang('recipe/review.choose'):</label>
        <ul class="rating j-rating-radio" data-rating>
            <li>
                <label for="rating_5">
                    <input type="radio" name="rating" id="rating_5" value="5"> 
                    @include('partials.icons.icon-star')
                </label>
            </li>
            <li>
                <label for="rating_4">
                    <input type="radio" name="rating" id="rating_4" value="4"> 
                    @include('partials.icons.icon-star')
                </label>
            </li>
            <li>
                <label for="rating_3">
                    <input type="radio" name="rating" id="rating_3" value="3"> 
                    @include('partials.icons.icon-star')
                </label>
            </li>
            <li>
                <label for="rating_2">
                    <input type="radio" name="rating" id="rating_2" value="2"> 
                    @include('partials.icons.icon-star')
                </label>
            </li>
            <li>
                <label for="rating_1">
                    <input type="radio" name="rating" id="rating_1" value="1"> 
                    @include('partials.icons.icon-star')
                </label>
            </li>
        </ul>
    </div>
</div>
<div class="form-row">
    <div class="form-item is-inline">
        <div class="form-input">
            {{ Form::text('title', $review->title, ['placeholder'=>trans('recipe/review.title')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item">
        <div class="form-input">
            {{ Form::textarea('details', $review->details, ['placeholder'=>trans('recipe/review.write_review_placeholder')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item is-inline">
        <label class="form-label">@lang('recipe/review.tags'):</label>
        <div class="form-input">
            {{ Form::select('tags[]', $tags, '', [
                's2_placeholder' => trans('community.placeholders.tags'),
                'maximumSelectionLength' => config('kosher.max_tags_ask_question'),
                'multiple' => 'multiple',
                'class' => 'js-select2'
            ]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item is-inline">
        <label class="form-label">@lang('recipe/review.chefs'):</label>
        <div class="form-input">
            {{ Form::select('chefs[]', $chefs, '', [
                's2_placeholder' => trans('community.placeholders.chefs'),
                'maximumSelectionLength' => config('kosher.max_chefs_ask_question'),
                'multiple' => 'multiple',
                'class' => 'js-select2'
            ]) }}
        </div>
    </div>
</div>
<div class="form-actions">
    <input type="submit"
           class="btn is-purple js-community-submit"
           value="@lang('recipe/review.write_reviews_post')"
           data-error="@lang('recipe/review.error_update_review')"
           data-container=".js-reviews-list-container"
    />
    <input type="button" class="link js-community-cancel" value="@lang('recipe/review.write_reviews_cancel')"/>
</div>

{{ Form::close() }}