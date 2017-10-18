@extends('layouts.1column', [
    'page_class' => 'page-lifestyle'
])

@section('title', trans('titles.lifestyle'))

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/lifestyle.js"></script>
@endpush

@section('content')
    <div class="lifestyle-page">
        <section class="page-heading @if ($bannerArticles->count()) has-banner @endif" style="background-image: url('{{ URL('/') }}/images/bg-lifestyle.jpg');">
            <div class="site-width">
                {!! Breadcrumbs::render('lifestyle') !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title"><span>@lang('pages/lifestyle.headings.explore')</span></h1>
                        <h2 class="heading-decorative__subtitle">@lang('pages/lifestyle.headings.lifestyle')</h2>
                    </div>
                </div>
            </div>
        </section>

        <div class="site-width">

            @if ($bannerArticles->count())
                @include('pages.lifestyle.banner')
            @endif

            @include('partials.separator')

        </div>

        <div class="lifestyle-page__content">
            <script>
                var trans = {!! json_encode($labels) !!},
                    json = {!! $results !!};

                json.noResults = {!! $noResults !!};
            </script>
            <div id="vue-app">
                <router-view></router-view>
            </div>
        </div>
    </div>

@endsection
