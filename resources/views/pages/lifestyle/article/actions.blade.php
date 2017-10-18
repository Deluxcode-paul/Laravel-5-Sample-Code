<div class="actions-nav__item is-share j-sharing-wrap">
    <button class="main j-sharing">
        @include('partials.icons.icon-share')
        <span>@lang('share.buttons.share')</span>
    </button>
    <div class="hidden">
        <div class="sharing">
            {!! BfmShare::render(null, $article->getUrl(), [], [
                'media' => $article->getImage('open_graph'),
                'shortText' => 'What We Are Reading',
                'shortUrl' => $article->getShortUrl()
            ]) !!}
        </div >
    </div>
</div>
<div class="actions-nav__item is-print">
    <a href="#" class="main js-print-article-button">
        @include('partials.icons.icon-print')
        <span>@lang('share.buttons.print')</span>
    </a>
</div>
<div class="actions-nav__item is-email j-mailing-wrap">
    <a href="#" class="main js-email-article-button j-mailing">
        @include('partials.icons.icon-mail')
        <span>@lang('share.buttons.email')</span>
    </a>
    <div class="hidden">
        <div class="mailing">
            @include('common.share.mail_form')
        </div>
    </div>
</div>