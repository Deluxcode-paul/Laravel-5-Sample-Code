<div class="js-account-preferences-view{{ old('section') == 'preferences' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.preferences')</h3>
        <button class="link-gold js-account-preferences-edit">
            @include('partials.icons.icon-edit')
            <span>
                @lang('user/profile.buttons.edit')
            </span>
        </button>
        @include('partials.separator')
    </div>
    <div class="form-profile">
        <div class="form-group">
            <div class="form-row">
                <div class="form-item">
                    <label class="form-label">@lang('user/profile.labels.free_of')</label>
                    <div class="form-column">
                        @if ($currentUser->allergens->count())
                        <ul class="list">
                            @foreach($currentUser->allergens as $allergen)
                                <li>{{ $allergen->title }}</li>
                            @endforeach
                        </ul>
                        @else
                            <div class="form-text">@lang('common.no_allergens')</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="form-item">
                    <label class="form-label">@lang('user/profile.labels.diet')</label>
                    <div class="form-column">
                        @if ($currentUser->diets->count())
                            <ul class="list">
                                @foreach($currentUser->diets as $diet)
                                    <li>{{ $diet->title }}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="form-text">@lang('common.no_diets')</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
