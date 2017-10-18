{{ Form::open([
    'url' => $formAction,
    'method' => 'POST',
    'class' => 'form-grey form-ask'
]) }}
<div class="form-row{{ $errors->has('details') ? ' has-error' : '' }}">
    <div class="form-item">
        {{ Form::label('details', trans('community.labels.details_edit'), [
            'class' => 'form-label'
        ]) }}

        <div class="form-input">
            {{ Form::textarea('details', $item->details, [
                'placeholder' => trans('community.placeholders.details_edit'),
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
<div class="form-actions">
    <button type="submit" class="btn is-purple is-large">
        @lang('community.buttons.save')
    </button>
    @include('community.blocks.delete_form', [
        'deleteFormAction' => $item->deleteUrl
    ])
</div>
{{ Form::close() }}