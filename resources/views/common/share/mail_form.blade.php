<div class="shopping__mail js-email-share-popup js-hidden">
    {{ Form::open([
        'url' => '',
        'method' => 'POST',
        'class' => 'form-grey form-profile js-email-share-form'
        ]) }}

    <div class="form-row">
        <div class="form-item is-inline">
            <div class="form-input">
                {{ Form::email('email', '', [
                    'placeholder' => trans('share.mail_to_placeholder'),
                    'maxlength' => 255,
                    'required',
                    ]) }}
            </div>

            <button type="submit" class="btn is-purple js-email-share-submit-button">
                 @lang('share.mail_to_submit')
                 @include('partials.icons.icon-letter')
            </button>

            {{ Form::button(trans('share.mail_to_cancel'), [
                 'class' => 'link js-email-share-cancel-button'
                 ]) }}
        </div>
    </div>

    {{ Form::close() }}
</div>
