@extends('user.profile.template', [
    'profile_class' => 'profile-account'
])

@section('title', trans('titles.profile.account_info'))

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.account') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.headings.account_information')
@endsection

@section('profile-content')
    <section class="section js-about-container">
        @include('user.profile.account.about_view')
        @include('user.profile.account.about_edit')
    </section>
    @if ($isChef)
    <section class="section js-social-container">
        @include('user.profile.account.social_view')
        @include('user.profile.account.social_edit')
    </section>
    @endif
    <section class="section js-preferences-container">
        @include('user.profile.account.preferences_view')
        @include('user.profile.account.preferences_edit')
    </section>
    @include('user.profile.account.subscription')
    @include('user.profile.account.delete')
@endsection

@section('inline_script')
    <script>
        Front.translations.delete_account_confirmation = '{{ trans('user/profile.js_messages.delete_account_confirmation') }}';
        Front.translations.subscription_error = '{{ trans('user/profile.js_messages.subscription_error') }}';
        Front.translations.save_error = '{{ trans('user/profile.js_messages.save_error') }}';
        Front.translations.save_success = '{{ trans('user/profile.js_messages.save_success') }}';
        Front.translations.load_error = '{{ trans('user/profile.js_messages.load_error') }}';
        Front.translations.send_email_error = '{{ trans('auth.verify_email_error') }}';
        Front.routes.about_edit = '{{ route('user.profile.account.edit.about') }}';
        Front.routes.social_edit = '{{ route('user.profile.account.edit.social') }}';
        Front.routes.preferences_edit = '{{ route('user.profile.account.edit.preferences') }}';
        Front.routes.resend_confirmation = '{{ route('user.profile.account.confirmation') }}';
        var is_confirmed = @if (!$currentUser->is_confirmed) false @else true @endif;
    </script>
@endsection