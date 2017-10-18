@extends('layouts.layout')

@section('site-content-layout')

    @yield('content')

@endsection

@section('site-footer-before')

    @if (isset($cta))
        @if ($cta == 1)
            <section id="js-section-cta" class="section-cta"></section>
        @endif
    @endif

    @if (!isset($newsletter) || $newsletter == 1)
        @include('common.newsletter')
    @endif

@endsection