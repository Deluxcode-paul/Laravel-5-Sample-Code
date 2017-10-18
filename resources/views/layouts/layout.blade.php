@extends('layouts.base')

@section('base')

    <div class="hide">
        @include('partials.svg-sprite')
    </div>

    <div class="site-wrapper" id="site-wrapper">

        <div class="site-wrapper__row">

            @section('site-header')
                @include('common.header')
            @show

            @yield('site-header-after')

            <main class="site-main" id="site-main">

                @yield('content-before')

                <div class="site-content" id="site-content">
                    @yield('site-content-layout')
                </div>

                @yield('content-after')

            </main>

            @yield('site-footer-before')

        </div>

        @section('site-footer')
            @include('common.footer')
        @show

    </div>

    <div class="popups-holder">
        @yield('popups')
    </div>

    @include('partials.preloader')
    @include('partials.overlay')

@endsection