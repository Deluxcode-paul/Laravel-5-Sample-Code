<div class="js-account-preferences-edit-container{{ old('section') != 'preferences' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.preferences')</h3>
        @include('partials.separator')
    </div>
    {{ Form::open([
        'url' => route('user.profile.account.save.preferences'),
        'method' => 'POST',
        'class' => 'form-grey form-profile js-account-preferences-form',
        'role' => 'form'
    ]) }}
    <input type="hidden" name="section" value="preferences" />
    <div class="form-group">
        <div class="form-row">
            <div class="form-item{{ $errors->has('allergens') ? ' has-error' : '' }}">
                <label class="form-label">@lang('user/profile.labels.free_of')</label>
                <div class="form-column">
                    <div class="list">
                        @foreach ($allergens as $allergen)
                            <label class="form-checkbox">
                                {{ Form::checkbox("allergens[]", $allergen->id, $currentUser->hasAllergen($allergen->id)) }}
                                <span class="form-checkbox__icon">
                                    @include('partials.icons.icon-check')
                                </span>
                                <span class="form-checkbox__title">{{ $allergen->title }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @if ($errors->has('allergens'))
                    <span class="help-block">
                        <strong>{{ $errors->first('allergens') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-row">
            <div class="form-item{{ $errors->has('diets') ? ' has-error' : '' }}">
                <label class="form-label">@lang('user/profile.labels.diet')</label>
                <div class="form-column">
                    <div class="list">
                        @foreach ($diets as $diet)
                            <label class="form-checkbox">
                                {{ Form::checkbox("diets[]", $diet->id, $currentUser->hasDiet($diet->id)) }}
                                <span class="form-checkbox__icon">
                                    @include('partials.icons.icon-check')
                                </span>
                                <span class="form-checkbox__title">{{ $diet->title }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @if ($errors->has('diets'))
                    <span class="help-block">
                        <strong>{{ $errors->first('diets') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn is-purple js-account-preferences-save">
            @lang('user/profile.buttons.save')
        </button>
        <a class="link js-account-preferences-cancel" href="#">
            @lang('user/profile.buttons.cancel')
        </a>
    </div>
    {{ Form::close() }}
</div>