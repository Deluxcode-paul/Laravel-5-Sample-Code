{{ Form::open([
    'url' => $formAction,
    'method' => 'POST',
    'class' => 'form-grey form-ask j-ask-form'
]) }}
<div class="form-row{{ $errors->has('title') ? ' has-error' : '' }}">
    <div class="form-item">
        {{ Form::label('title', trans('community.labels.title'), [
            'class' => 'form-label'
        ]) }}

        <div class="form-input">
            {{ Form::text('title', $item->title, [
                'placeholder' => trans('community.placeholders.title'),
                 'maxlength' => 255,
                 'required',
                 'class' => 'form-control',
             ]) }}

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-row{{ $errors->has('details') ? ' has-error' : '' }}">
    <div class="form-item">
        {{ Form::label('details', trans('community.labels.details'), [
            'class' => 'form-label'
        ]) }}

        <div class="form-input">
            {{ Form::textarea('details', $item->details, [
                'placeholder' => trans('community.placeholders.details'),
                 'required',
                 'class' => 'form-control',
             ]) }}

            @if ($errors->has('details'))
                <span class="help-block">
                    <strong>{{ $errors->first('details') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
@if ($item->hasRating)
    <div class="form-row">
        <div class="form-item">
            <label class="form-label rating-label">@lang('community.labels.rating'):</label>
            <ul class="rating j-rating-radio" data-rating="{{ $item->rating }}">
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
@endif
<div class="form-row">
    <div class="form-item">
        <label for="tags" class="form-label">
            @lang('community.labels.tags')
            <span>@lang('community.helpers.tags')</span>
        </label>
        <div class="form-input">
            {{ Form::select('tags[]', $tags, $item->tags->pluck('id')->toArray(), [
                's2_placeholder' => trans('community.placeholders.tags'),
                'maximumSelectionLength' => config('kosher.max_tags_ask_question'),
                'multiple' => 'multiple',
                'required',
                'class' => 'js-select2'
            ]) }}

            @if ($errors->has('tags'))
                <span class="help-block">
                    <strong>{{ $errors->first('tags') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-item">
        <label for="chefs" class="form-label">
            @lang('community.labels.chefs')
            <i>@lang('community.helpers.chefs')</i>
        </label>
        <div class="form-input">
            {{ Form::select('chefs[]', $chefs, $item->chefs->pluck('id')->toArray(), [
                's2_placeholder' => trans('community.placeholders.chefs'),
                'maximumSelectionLength' => config('kosher.max_chefs_ask_question'),
                'multiple' => 'multiple',
                'class' => 'js-select2'
            ]) }}

            @if ($errors->has('chefs'))
                <span class="help-block">
                    <strong>{{ $errors->first('chefs') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn is-purple is-large">
        @lang('community.buttons.save')
    </button>
    @include('community.blocks.delete_form', [
        'deleteFormAction' => $item->deleteUrl
    ])
</div>
{{ Form::close() }}