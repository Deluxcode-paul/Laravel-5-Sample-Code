{{ Form::open([
       'method'=>'POST',
       'url' => $comment->id
               ? route('article-comments.save', [$comment->article_id, $comment->id])
               : route('article-comments.add',[$comment->article_id]),
       'class' => 'form form-grey form-community'
   ]) }}

{{ Form::hidden('id', $comment->id, ['class' => 'js-form-hidden-id']) }}

<div class="form-row">
    <div class="form-item is-inline">
        <div class="form-input">
            {{ Form::text('title', $comment->title, ['placeholder'=>trans('pages/comments.title')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item">
        <div class="form-input">
            {{ Form::textarea('details', $comment->details, ['placeholder'=>trans('pages/comments.write_comment_placeholder')]) }}
        </div>
    </div>
</div>
<div class="form-row">
    <div class="form-item is-inline">
        <label class="form-label">@lang('pages/comments.tags'):</label>
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
        <label class="form-label">@lang('pages/comments.chefs'):</label>
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
       value="@lang('pages/comments.write_comment_post')"
       data-error="@lang('pages/comments.error_update_comment')"
       data-container=".js-comments-list-container"
    />
    <input type="button" class="link js-community-cancel"  value="@lang('pages/comments.write_comment_cancel')"/>
</div>

{{ Form::close() }}