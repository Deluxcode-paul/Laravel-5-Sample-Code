@extends('layouts.1column', [
    'page_class' => 'page-profile'
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/profile.js"></script>
@endpush

@section('content')
    <section class="profile {{ isset($profile_class) ? $profile_class : '' }}">
        <section class="breadcrumbs" style="background-image: url('{{ URL('/') }}/images/bg-profile.jpg')">
            <div class="site-width">
                @yield('profile-breadcrumbs')
            </div>
        </section>
        <div class="site-width">
            <div class="profile__wrapper">
                @include('user.profile.sidebar')
                <section class="profile__content">
                    <h1 class="main-title">@yield('profile-section-title')</h1>
                    @yield('profile-content')
                </section>
            </div>
        </div>
    </section>
@endsection