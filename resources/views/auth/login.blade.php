@extends('layouts.1column', [
    'newsletter' => 0
])

@section('title', trans('titles.login'))

@push('footer_js')
    <script src="{{ URL('/') }}/js/auth.js"></script>
@endpush

@section('content')
    <div class="page-auth" id="js-page-auth" style="background-image: url('{{ URL('/') }}/images/bg-login.jpg');">
        <div class="page-auth__container site-width">
            <div class="spacer">
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title">
                        <span>@lang('auth.headings.login')</span>
                    </h1>
                    <h2 class="heading-decorative__subtitle">@lang('auth.headings.welcome')</h2>
                </div>
                <div class="page-auth__forms box-tabs">
                    <ul class="tabset uppercase">
                        <li class="r-tabs-state-active"><a href="{{ route('login') }}">@lang('auth.sections.login')</a></li>
                        <li><a href="{{ $registerUrl }}">@lang('auth.sections.register')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab" id="login">
                            {{ Form::open([
                                'url' => route('login'),
                                'method' => 'POST',
                                'class' => 'form js-form form-login form-grey',
                                'novalidate',
                                'role' => 'form'
                            ]) }}
                            {{ Form::hidden('destination', Request::input('destination')) }}
                                <div class="form-row">
                                    <div class="form-item">
                                        {{ Form::label('email', trans('auth.labels.email'), [
                                            'class' => 'form-label'
                                        ]) }}
                                        <div class="form-input">
                                            @if ($errors->has('email'))
                                                <span class="form-item-errors">
                                                    <span>{{ $errors->first('email') }}</span>
                                                </span>
                                            @endif
                                            {{ Form::text('email', old('email'), [
                                                'placeholder' => trans('auth.placeholders.email'),
                                                'maxlength' => 255,
                                                'required',
                                                'autofocus',
                                                'class' => $errors->has('email') ? 'form-control parsley-error' : 'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-item">
                                        {{ Form::label('password', trans('auth.labels.password'), [
                                            'class' => 'form-label'
                                        ]) }}
                                        <div class="form-input">
                                            @if ($errors->has('password'))
                                                <span class="form-item-errors">
                                                    <span>{{ $errors->first('password') }}</span>
                                                </span>
                                            @endif
                                            {{ Form::password('password', [
                                                'placeholder' => trans('auth.placeholders.password'),
                                                'required',
                                                'class' => $errors->has('password') ? 'form-control parsley-error' : 'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-item">
                                        <div class="form-input">
                                            <label class="form-checkbox">
                                                {{ Form::checkbox('remember') }}
                                                <span class="form-checkbox__icon">
                                                    @include('partials.icons.icon-check')
                                                </span>
                                                <span class="form-checkbox__title">@lang('auth.labels.remember')</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-item a-right">
                                        <a class="link-forgot form-link" href="{{ route('forgot_password') }}">
                                            @lang('auth.buttons.forgot')
                                        </a>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn is-large">
                                        @lang('auth.buttons.login')
                                    </button>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
