<div class="js-account-about-edit-container{{ old('section') != 'about' ? ' js-hidden' :'' }}">
    <div class="headering">
        <h3 class="title">@lang('user/profile.headings.about')</h3>
        @include('partials.separator')
    </div>
    {{ Form::open([
        'url' => route('user.profile.account.save.about'),
        'method' => 'POST',
        'class' => 'form-grey form-profile js-account-about-form',
        'role' => 'form',
        'autocomplete' => 'off'
    ]) }}
    <input type="text" style="display:none" />
    <input type="password" style="display:none" />
    <input type="hidden" name="section" value="about" />
    <div class="form-row">
        <div class="form-item">
            {{ Form::label('name', trans('user/profile.labels.username'), [
                'class' => 'form-label'
            ]) }}
            <div class="form-input">
                {{ Form::text('name', $currentUser->name, [
                    'placeholder' => trans('user/profile.placeholders.username'),
                     'maxlength' => 255,
                     'disabled',
                     'class' => 'form-control'
                ]) }}
            </div>
        </div>
        <div class="form-item">
            {{ Form::label('first_name', trans('user/profile.labels.first_name'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::text('first_name', $currentUser->first_name, [
                    'placeholder' => trans('user/profile.placeholders.first_name'),
                     'maxlength' => 255,
                     'required',
                     'class' => $errors->has('first_name') ? 'form-control parsley-error' : 'form-control',
                 ]) }}

                @if ($errors->has('first_name'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('first_name') }}</span>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-item">
            {{ Form::label('first_name', trans('user/profile.labels.last_name'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::text('last_name', $currentUser->last_name, [
                    'placeholder' => trans('user/profile.placeholders.last_name'),
                     'maxlength' => 255,
                     'class' => $errors->has('last_name') ? 'form-control parsley-error' : 'form-control',
                 ]) }}

                @if ($errors->has('last_name'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('last_name') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            {{ Form::label('email', trans('user/profile.labels.email'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::email('email', $currentUser->email, [
                    'placeholder' => trans('user/profile.placeholders.email'),
                     'maxlength' => 255,
                     'disabled',
                     'class' => 'form-control',
                ]) }}
            </div>
        </div>

        <div class="form-item">
            {{ Form::label('password', trans('user/profile.labels.password'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::password('password', [
                    'placeholder' => trans('user/profile.placeholders.password'),
                    'maxlength' => 255,
                    'class' => $errors->has('password') ? 'form-control parsley-error' : 'form-control',
                    'data-parsley-minlength' => 8
                ]) }}

                @if ($errors->has('password'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('password') }}</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-item">
            {{ Form::label('password_confirmation', trans('user/profile.labels.confirm_password'), [
                'class' => 'form-label'
            ]) }}
            <div class="form-input">
                {{ Form::password('password_confirmation', [
                    'placeholder' => trans('user/profile.placeholders.confirm_password'),
                    'class' => $errors->has('password_confirmation') ? 'form-control parsley-error' : 'form-control',
                    'data-parsley-equalto' => '#password',
                    'data-parsley-minlength' => 8,
                ]) }}

                @if ($errors->has('password_confirmation'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('password_confirmation') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @if ($isChef)
    <div class="form-row">
        <div class="form-item">
            {{ Form::label('bio', trans('user/profile.labels.bio'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input j-texterea-length">
                {{ Form::textarea('bio', $currentUser->bio, [
                    'placeholder' => trans('user/profile.placeholders.bio'),
                    'maxlength' => 1000,
                    'class' => $errors->has('bio') ? 'form-control form-control--textarea parsley-error' : 'form-control form-control--textarea'
                 ]) }}
                <div class="results">
                    <output></output> / <span>1000</span>
                </div>

                @if ($errors->has('bio'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('bio') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            {{ Form::label('city', trans('user/profile.labels.city'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::text('city', $currentUser->city, [
                    'placeholder' => trans('user/profile.placeholders.city'),
                    'class' => $errors->has('city') ? 'form-control parsley-error' : 'form-control',
                 ]) }}

                @if ($errors->has('city'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('city') }}</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-item">
            {{ Form::label('country_id', trans('user/profile.labels.country'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input">
                {{ Form::select('country_id', $countries, $currentUser->country_id, [
                    'placeholder' => trans('user/profile.placeholders.country'),
                    'class' => $errors->has('country_id') ? 'js-select2 parsley-error' : 'js-select2',
                ]) }}

                @if ($errors->has('country_id'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('country_id') }}</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-item">
            <div class="js-state-container">
                {{ Form::label('state_id', trans('user/profile.labels.state'), [
                    'class' => 'form-label'
                ]) }}

                <div class="form-input">
                    {{ Form::select('state_id', $states, $currentUser->state_id, [
                        'placeholder' => trans('user/profile.placeholders.state')
                    ]) }}

                    @if ($errors->has('state_id'))
                        <span class="form-item-errors">
                            <span>{{ $errors->first('state_id') }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            {{ Form::label('place_of_work', trans('user/profile.labels.place_of_work'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input j-texterea-length">
                {{ Form::textarea('place_of_work', $currentUser->place_of_work, [
                    'placeholder' => trans('user/profile.placeholders.place_of_work'),
                    'maxlength' => 255,
                    'class' =>  $errors->has('place_of_work') ? 'form-control form-control--textarea form-control--textareasmall parsley-error' : 'form-control form-control--textarea form-control--textareasmall'
                ]) }}
                <div class="results">
                    <output></output> / <span>255</span>
                </div>

                @if ($errors->has('place_of_work'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('place_of_work') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-item">
            {{ Form::label('status', trans('user/profile.labels.status'), [
                'class' => 'form-label'
            ]) }}

            <div class="form-input j-texterea-length">
                {{ Form::textarea('status', $currentUser->status, [
                    'placeholder' => trans('user/profile.placeholders.status'),
                    'maxlength' => 140,
                    'class' => $errors->has('status') ? 'form-control form-control--textarea form-control--textareasmall parsley-error' : 'form-control form-control--textarea form-control--textareasmall'
                ]) }}
                <div class="results">
                    <output></output> / <span>140</span>
                </div>

                @if ($errors->has('status'))
                    <span class="form-item-errors">
                        <span>{{ $errors->first('status') }}</span>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="form-actions">
        <button type="submit" class="btn is-purple js-account-about-save">
            @lang('user/profile.buttons.save')
        </button>
        <a class="link js-account-about-cancel" href="#">
            @lang('user/profile.buttons.cancel')
        </a>
    </div>
    {{ Form::close() }}
</div>