{{ Form::open([
       'method'=>'POST',
       'url' => $question->id
               ? route('recipe.questions.save', [$question->recipe_id, $question->id])
               : route('recipe.questions.add',[$question->recipe_id]),
       'class' => 'forform form-grey form-community'
   ]) }}

{{ Form::hidden('id', $question->id, ['class' => 'js-form-hidden-id']) }}

<div class="form-row">
    <div class="form-item is-inline">
        <div class="form-input">
            {{ Form::text('title', $question->title, ['placeholder'=>trans('recipe/questions.title')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item">
        <div class="form-input">
            {{ Form::textarea('details', $question->details, ['placeholder'=>trans('recipe/questions.write_question_placeholder')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item is-inline">
        <label class="form-label">@lang('recipe/questions.tags'):</label>
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
        <label class="form-label">@lang('recipe/questions.chefs'):</label>
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
       value="@lang('recipe/questions.write_question_post')"
       data-error="@lang('recipe/questions.error_update_question')"
       data-container=".js-questions-list-container"
    />
    <input type="button" class="link js-community-cancel"  value="@lang('recipe/questions.write_question_cancel')"/>
</div>

{{ Form::close() }}