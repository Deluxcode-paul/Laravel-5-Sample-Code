@if ($video->canBeSaved())
    <div class="js-save-recipe-wrapper actions-nav__item is-save">
        @if ($video->owner->isSaved())
            <span class="main saved">
                @include('partials.icons.icon-star')
                <span>@lang('share.buttons.saved')</span>
            </span>
        @else
            <a href="#"
               class="main js-save-video-button"
               data-recipe-id="{{ $video->owner->id }}"
               data-error="{{ trans('recipe/view.recipe_box_error') }}">
                @include('partials.icons.icon-star')
                <span>@lang('share.buttons.save')</span>
            </a>
        @endif
    </div>
@endif
<div class="actions-nav__item is-share j-sharing-wrap">
    <button class="main j-sharing">
        @include('partials.icons.icon-share')
        <span>@lang('share.buttons.share')</span>
    </button>
    <div class="hidden">
        <div class="sharing">
            {!! BfmShare::render(null, route('watch.video', $video->id), [], [
                'media' => $video->getImage('open_graph'),
                'shortText' => 'What We Are Watching',
                'shortUrl' => $video->getShortUrl()
            ]) !!}
        </div>
    </div>
</div>
<div class="actions-nav__item is-email j-mailing-wrap">
    <a href="#" class="main js-email-video-button j-mailing">
        @include('partials.icons.icon-mail')
        <span>@lang('share.buttons.email')</span>
    </a>
    <div class="hidden">
        <div class="mailing">
            @include('common.share.mail_form')
        </div>
    </div>
</div>