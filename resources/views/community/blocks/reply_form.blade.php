<div class="community-block">
    @if (empty($currentUser))
        <div class="community-block__header">
            <div class="community-block__notify">
                @lang('community.login_action_required', ['login_url' => route('login')])
                <span class="fake-input">@lang('community.placeholders.reply')</span>
                <span class="fake-button">@lang('community.buttons.reply')</span>
            </div>
        </div>
    @else
        <div class="community-block__form">
            {{ Form::open([
                'url' => $replyFormRoute,
                'method' => 'POST',
                'class' => 'form form-grey form-community js-reply-form'
            ]) }}
            <div class="form-row">
                <div class="form-item is-inline">
                    <div class="form-input">
                        {{ Form::textarea('details', '', [
                            'placeholder' => trans('community.placeholders.reply'),
                         ]) }}
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn is-purple js-reply-button">
                    @lang('community.buttons.reply')
                </button>
            </div>
            {{ Form::close() }}
        </div>
    @endif
</div>

