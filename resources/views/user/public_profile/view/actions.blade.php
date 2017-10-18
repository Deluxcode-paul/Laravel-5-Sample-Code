<div class="actions-nav__item is-share j-sharing-wrap">
    <button class="main j-sharing">
        @include('partials.icons.icon-share')
        <span>@lang('share.buttons.share')</span>
    </button>
    <div class="hidden">
        <div class="sharing">
            {!! BfmShare::render(null, route('user.view', $user->id), [], [
                'media' => $user->getImage('open_graph'),
                'shortText' => 'Who We Are Following',
                'shortUrl' => $user->getShortUrl()
            ]) !!}
        </div >
    </div>
</div>
<div class="actions-nav__item is-email j-mailing-wrap">
    <a href="#" class="main js-email-profile-button j-mailing">
        @include('partials.icons.icon-mail')
        <span>@lang('share.buttons.email')</span>
    </a>
    <div class="hidden">
        <div class="mailing">
            @include('common.share.mail_form')
        </div>
    </div>
</div>