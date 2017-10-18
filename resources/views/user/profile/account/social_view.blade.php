<div class="js-account-social-view{{ old('section') == 'social' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.social')</h3>
        <button class="link-gold js-account-social-edit">
            @include('partials.icons.icon-edit')
            <span>
                @lang('user/profile.buttons.edit')
            </span>
        </button>
        @include('partials.separator')
    </div>
    <div class="form-profile">
        <div class="form-row">
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-facebook')
                </label>
                <div class="form-text">
                    @if ($currentUser->facebook)
                        {{ $currentUser->facebook }}
                    @else
                        ―
                    @endif
                </div>
            </div>
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-youtube')
                </label>
                <div class="form-text">
                    @if ($currentUser->youtube)
                        {{ $currentUser->youtube }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-instagram')
                </label>
                <div class="form-text">
                    @if ($currentUser->instagram)
                        {{ $currentUser->instagram }}
                    @else
                        ―
                    @endif
                </div>
            </div>
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-pinterest')
                </label>
                <div class="form-text">
                    @if ($currentUser->pinterest)
                        {{ $currentUser->pinterest }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-twitter')
                </label>
                <div class="form-text">
                    @if ($currentUser->twitter)
                        {{ $currentUser->twitter }}
                    @else
                        ―
                    @endif
                </div>
            </div>
            <div class="form-item is-inline">
                <label class="form-label">
                    @include('partials.icons.icon-link')
                </label>
                <div class="form-text">
                    @if ($currentUser->website)
                        {{ $currentUser->website }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>