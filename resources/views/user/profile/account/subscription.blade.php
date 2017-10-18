<section class="section">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.subscription')</h3>
        @include('partials.separator')
    </div>
    <p class="desc">@lang('user/profile.content.subscription')</p>
    {{ Form::open([
            'url' => route('user.profile.account.save.subscription'),
            'method' => 'POST',
            'class' => 'js-subscription-form',
        ]) }}

        <label class="form-checkbox">
            {{ Form::checkbox('is_subscribed', 1, $currentUser->is_subscribed, [
                'class' => 'js-subscription-checkbox'
            ]) }}
            <span class="form-checkbox__icon">
                @include('partials.icons.icon-check')
            </span>
            <span class="form-checkbox__title">@lang('user/profile.labels.subscription')</span>
        </label>

    {{ Form::close() }}
    @if (!$currentUser->is_confirmed)
        <br/>
        <p class="desc">@lang('auth.verify_email_notification')</p>
        <button class="link js-resend-email-confirmation">
            @lang('user/profile.buttons.resend_email_confirmation')
        </button>
    @endif
</section>