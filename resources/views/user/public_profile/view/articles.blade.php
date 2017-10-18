@if ($user->articles()->published()->count() > 0)
    <div class="chef__bookmark js-articles-container" id="articles">
        <ul class="grid with-related js-articles-list">
            @include('user.public_profile.view.articles.items')
        </ul>
        @if ($articles->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-articles-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif