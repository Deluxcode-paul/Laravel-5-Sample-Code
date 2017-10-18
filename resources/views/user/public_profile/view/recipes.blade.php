@if ($user->recipes->count() > 0)
    <div class="chef__bookmark js-recipes-container" id="recipes">
        <ul class="grid js-recipes-list">
            @include('user.public_profile.view.recipes.items')
        </ul>
        @if ($recipes->hasMorePages())
            <div class="a-center actions">
                <a href="#" class="btn is-purple js-load-recipes-button">@lang('user/profile.buttons.load_more')</a>
            </div>
        @endif
    </div>
@endif