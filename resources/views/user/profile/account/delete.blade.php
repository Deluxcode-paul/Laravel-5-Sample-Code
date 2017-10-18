<section class="section">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.delete')</h3>
        @include('partials.separator')
    </div>
    <p class="desc">@lang('user/profile.content.delete_account')</p>
    {{ Form::open([
        'url' => route('user.profile.account.delete'),
        'method' => 'POST',
        'class' => 'form-profile js-delete-account-form',
        'role' => 'form'
    ]) }}
    <button class="link js-account-delete">
        @lang('user/profile.buttons.delete_account')
    </button>
    {{ Form::close() }}
</section>