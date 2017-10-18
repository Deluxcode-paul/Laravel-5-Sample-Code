@if ($videos->count() > 0)
    <div class="chef__bookmark js-videos-container" id="videos">
        <ul class="grid js-videos-list">
            @include('user.public_profile.view.videos.items')
        </ul>
        @if ($videos->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-videos-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif