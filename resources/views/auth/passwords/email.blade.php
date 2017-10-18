@extends('layouts.1column', [
    'newsletter' => 0
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/auth.js"></script>
@endpush

@section('title', trans('titles.forgot_password'))

@section('content')
    <div class="page-auth" id="js-page-auth" style="background-image: url('{{ URL('/') }}/images/bg-register.jpg');" data-bg-login="/images/bg-login.jpg" data-bg-register="/images/bg-register.jpg">
        <div class="page-auth__container site-width">
            <div class="spacer">
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title">
                        <span>@lang('auth.headings.forgot')</span>
                    </h1>
                    <h2 class="heading-decorative__subtitle">@lang('auth.headings.password')</h2>
                </div>
                <div class="page-auth__forms box-tabs">
                    <div class="tab-content">
                        <div class="tab">

                            {{ Form::open([
                                'url' => route('send_forgot_password_email'),
                                'method' => 'POST',
                                'class' => 'form js-form form-login form-grey',
                                'role' => 'form'
                            ]) }}

                            @if (session('status'))
                                <div class="form-text">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-item">
                                    {{ Form::label('email', trans('auth.labels.email'), [
                                        'class' => 'form-label'
                                    ]) }}
                                    <div class="form-input">
                                        @if ($errors->has('email'))
                                            <div class="form-item-errors">
                                                <span>{{ $errors->first('email') }}</sapn>
                                            </div>
                                        @endif
                                        {{ Form::email('email', old('email'), [
                                            'placeholder' => trans('auth.placeholders.email'),
                                            'maxlength' => 255,
                                            'required',
                                            'autofocus',
                                            'class' => $errors->has('email') ? 'form-control parsley-error' : 'form-control'
                                        ]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn is-large">
                                   @lang('auth.buttons.send_forgot_password_email')
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
