<div class="js-account-social-edit-container{{ old('section') != 'social' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.social')</h3>
        @include('partials.separator')
    </div>
    {{ Form::open([
        'url' => route('user.profile.account.save.social'),
        'method' => 'POST',
        'class' => 'form-grey  form-profile js-account-social-form',
        'role' => 'form'
    ]) }}
    <input type="hidden" name="section" value="social" />

    <div class="form-row">
        <div class="form-item is-inline{{ $errors->has('facebook') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-facebook')
            </label>

            <div class="form-input">
                {{ Form::text('facebook', $currentUser->facebook, [
                    'placeholder' => trans('user/profile.placeholders.facebook'),
                     'maxlength' => 255,
                     'class' => $errors->first('facebook') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('facebook'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('facebook') }}</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item is-inline{{ $errors->has('youtube') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-youtube')
            </label>

            <div class="form-input">
                {{ Form::text('youtube', $currentUser->youtube, [
                    'placeholder' => trans('user/profile.placeholders.youtube'),
                     'maxlength' => 255,
                     'class' => $errors->first('youtube') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('youtube'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('youtube') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-item is-inline{{ $errors->has('instagram') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-instagram')
            </label>

            <div class="form-input">
                {{ Form::text('instagram', $currentUser->instagram, [
                    'placeholder' => trans('user/profile.placeholders.instagram'),
                     'maxlength' => 255,
                     'class' => $errors->first('instagram') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('instagram'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('instagram') }}</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item is-inline{{ $errors->has('pinterest') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-pinterest')
            </label>

            <div class="form-input">
                {{ Form::text('pinterest', $currentUser->pinterest, [
                    'placeholder' => trans('user/profile.placeholders.pinterest'),
                     'maxlength' => 255,
                     'class' => $errors->first('pinterest') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('pinterest'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('pinterest') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-item is-inline{{ $errors->has('twitter') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-twitter')
            </label>

            <div class="form-input">
                {{ Form::text('twitter', $currentUser->twitter, [
                    'placeholder' => trans('user/profile.placeholders.twitter'),
                     'maxlength' => 255,
                     'class' => $errors->first('twitter') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('twitter'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('twitter') }}</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item is-inline{{ $errors->has('website') ? ' has-error' : '' }}">
            <label class="form-label">
                @include('partials.icons.icon-link')
            </label>

            <div class="form-input">
                {{ Form::text('website', $currentUser->website, [
                    'placeholder' => trans('user/profile.placeholders.website'),
                     'maxlength' => 255,
                     'class' => $errors->first('website') ? 'form-control parsley-error' : 'form-control',
                     'data-parsley-type' => 'url'
                 ]) }}
                @if ($errors->has('website'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('website') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-actions is-inline">
        <button type="submit" class="btn is-purple js-account-social-save">
            @lang('user/profile.buttons.save')
        </button>
        <a class="link js-account-social-cancel" href="#">
            @lang('user/profile.buttons.cancel')
        </a>
    </div>
    {{ Form::close() }}
</div>