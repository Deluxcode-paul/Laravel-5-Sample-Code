<div class="js-account-about-view{{ old('section') == 'about' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.about')</h3>
        <button class="link-gold js-account-about-edit">
            @include('partials.icons.icon-edit')
            <span>
                @lang('user/profile.buttons.edit')
            </span>
        </button>
        @include('partials.separator')
    </div>
    <div class="form form-profile">
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.username')</label>
                <div class="form-text">{{ $currentUser->name }}</div>
            </div>
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.first_name')</label>
                <div class="form-text">{{ $currentUser->first_name }}</div>
            </div>
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.last_name')</label>
                <div class="form-text">{{ $currentUser->last_name }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.email')</label>
                <div class="form-text">{{ $currentUser->email }}</div>
            </div>
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.password')</label>
                <div class="form-text"><span class="pass">********</span></div>
            </div>
             <div class="form-item"></div>
        </div>
        @if ($isChef)
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.bio')</label>
                <div class="form-text form-text--textarea">
                    @if ($currentUser->bio)
                        {!! nl2br(e($currentUser->bio)) !!}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.city')</label>
                <div class="form-text">
                    @if ($currentUser->city)
                        {{ $currentUser->city }}
                    @else
                        ―
                    @endif
                </div>
            </div>
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.country')</label>
                <div class="form-text">
                    @if ($currentUser->country)
                        {{ $currentUser->country->title }}
                    @else
                        ―
                    @endif
                </div>
            </div>
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.state')</label>
                <div class="form-text">
                    @if ($currentUser->state)
                        {{ $currentUser->state->title }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.place_of_work')</label>
                <div class="form-text form-text--textarea">
                    @if ($currentUser->place_of_work)
                        {{ $currentUser->place_of_work }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-item">
                <label class="form-label">@lang('user/profile.labels.status')</label>
                <div class="form-text form-text--textarea">
                    @if ($currentUser->status)
                        {{ $currentUser->status }}
                    @else
                        ―
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
