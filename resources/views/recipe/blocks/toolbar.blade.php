<div class="actions-nav j-action-share">
    <div class="js-save-recipe-wrapper actions-nav__item is-save">
        @if ($recipe->isSaved())
            <span class="main saved">
                @include('partials.icons.icon-star')
                <span>@lang('share.buttons.saved')</span>
            </span>
        @else
            <button type="button"
                    class="main js-add-to-recipe-box"
                    data-recipe-id="{{ $recipe->id }}"
                    data-error="@lang('recipe/view.recipe_box_error')"
            >
                @include('partials.icons.icon-star')
                <span>@lang('share.buttons.save')</span>
            </button>
        @endif
    </div>
    <div class="actions-nav__item is-share j-sharing-wrap">
        <button class="main j-sharing">
            @include('partials.icons.icon-share')
            <span>@lang('share.buttons.share')</span>
        </button>
        <div class="hidden">
            <div class="sharing">
                {!! BfmShare::render(null, $recipe->getUrl(), [], [
                    'media' => $recipe->getImage('open_graph'),
                    'shortText' => 'What We Are Cooking',
                    'shortUrl' => $recipe->getShortUrl()
                ]) !!}
            </div >
        </div>
    </div>
    <div class="actions-nav__item is-pdf">
        <a href="{{route('recipe.pdf', [$recipe->id])}}" class="main" target="_blank">
            @include('partials.icons.icon-download')
            <span>@lang('share.buttons.pdf')</span>
        </a>
    </div>
    <div class="actions-nav__item is-print">
        <a href="javascript:;" id="printButton" class="main">
            @include('partials.icons.icon-print')
            <span>@lang('share.buttons.print')</span>
        </a>
        <input type="hidden" name="" id="js_printUrl" value="{{ $recipe->getPrintUrl() }}">
    </div>
    <div class="actions-nav__item is-email j-mailing-wrap">
        <a href="javascript:;" class="main j-mailing">
            @include('partials.icons.icon-mail')
            <span>@lang('share.buttons.email')</span>
        </a>
        <div class="hidden">
            <div class="mailing">
                @include('common.share.mail_form')
            </div>
        </div>
    </div>
</div>