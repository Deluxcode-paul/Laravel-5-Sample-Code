@extends('layouts.1column', [
    'newsletter' => 0
])

@section('title', trans('titles.register'))

@push('footer_js')
    <script src="{{ URL('/') }}/js/auth.js"></script>
@endpush

@section('content')
    <div class="page-auth" id="js-page-auth" style="background-image: url('{{ URL('/') }}/images/bg-register.jpg');">
        <div class="page-auth__container site-width">
            <div class="spacer">
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title">
                        <span>@lang('auth.headings.register')</span>
                    </h1>
                    <h2 class="heading-decorative__subtitle">@lang('auth.headings.join')</h2>
                </div>
                <div class="page-auth__forms box-tabs">
                    <ul class="tabset uppercase">
                        <li><a href="{{ $loginUrl }}">@lang('auth.sections.login')</a></li>
                        <li class="r-tabs-state-active"><a href="{{ route('register') }}">@lang('auth.sections.register')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab" id="register">
                            {{ Form::open([
                                'url' => route('register'),
                                'method' => 'POST',
                                'class' => 'form js-form form-register form-grey',
                                'novalidate',
                                'role' => 'form'
                            ]) }}
                            {{ Form::hidden('destination', Request::input('destination')) }}
                                <div class="form-row">
                                    <div class="form-item">
                                        {{ Form::label('name', trans('auth.labels.username'), [
                                            'class' => 'form-label'
                                        ]) }}
                                        <div class="form-input">
                                            @if ($errors->has('name'))
                                                <span class="form-item-errors">
                                                    <span>{{ $errors->first('name') }}</span>
                                                </span>
                                            @endif
                                            {{ Form::text('name', old('name'), [
                                                'placeholder' => trans('auth.placeholders.username'),
                                                'maxlength' => 255,
                                                'required',
                                                'autofocus',
                                                'class' => $errors->has('name') ? 'form-control parsley-error' : 'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-item">
                                        {{ Form::label('first_name', trans('auth.labels.first_name'), [
                                            'class' => 'form-label'
                                        ]) }}
                                        <div class="form-input">
                                            @if ($errors->has('first_name'))
                                                <span class="form-item-errors">
                                                    <span>{{ $errors->first('first_name') }}</span>
                                                </span>
                                            @endif
                                            {{ Form::text('first_name', old('first_name'), [
                                                'placeholder' => trans('auth.placeholders.first_name'),
                                                'maxlength' => 255,
                                                'required',
                                                'class' => $errors->has('first_name') ? 'form-control parsley-error' : 'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-item">
                                        <label for="last_name" class="form-label">
                                            {{ trans('auth.labels.last_name') }}
                                            <small>({{ trans('global.optional') }})</small>
                                        </label>
                                        <div class="form-input">
                                            @if ($errors->has('last_name'))
                                                <span class="form-item-errors">
                                                    <span>{{ $errors->first('last_name') }}</span>
                                                </span>
                                            @endif
                                            {{ Form::text('last_name', old('last_name'), [
                                                'id' => 'last_name',
                                                'placeholder' => trans('auth.placeholders.last_name'),
                                                'maxlength' => 255,
                                                'class' => $errors->has('last_name') ? 'form-control parsley-error' : 'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

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
                                            {{ Form::email('email', old('email'), [
                                                'placeholder' => trans('auth.placeholders.email'),
                                                'maxlength' => 255,
                                                'required',
                                                'class' => $errors->has('email') ? 'form-control parsley-error' : 'form-control',
                                                'data-parsley-type-message' => trans('auth.validation.email')
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
                                    <div class="form-item{{ $errors->has('terms') ? ' has-error' : '' }}">
                                        <label class="form-checkbox">
                                            {{ Form::checkbox('terms', 1, false, [
                                                'required' => true
                                            ]) }}
                                            <span class="form-checkbox__icon">
                                                @include('partials.icons.icon-check')
                                            </span>
                                            <span class="form-checkbox__title">
                                                @lang('auth.texts.accept')
                                                <a class="form-link" href="{{ config('kosher.links.terms') }}">@lang('auth.texts.terms')</a>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn is-large">
                                        @lang('auth.buttons.register')
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