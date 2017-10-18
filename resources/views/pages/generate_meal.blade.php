@extends('layouts.1column', [
    'page_class' => 'page-generate-meal'
])

@section('title', trans('titles.generate_a_meal'))

@section('content')
    <div class="generate-meal">
        <section class="page-heading generate-meal__heading" style="background-image: url('{{ URL('/') }}/images/bg-generate-meal.jpg');">
            <div class="site-width">
                {!! Breadcrumbs::render('generate-a-meal') !!}
                <div class="page-heading__spacer spacer" spacer>
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title"><span>@lang('pages/generate_meal.headings.generate')</span></h1>
                        <h2 class="heading-decorative__subtitle">@lang('pages/generate_meal.headings.meal')</h2>
                    </div>
                    <div class="page-heading__descr">@lang('pages/generate_meal.headings.text')</div>
                </div>
            </div>
        </section>

        <script>
            var trans = {!! json_encode($labels) !!},
                json = {!! $results !!};

            json.noResults = {!! $noResults !!};
            json.ingredients = {!! $ingredients !!};
        </script>

        <div id="vue-app">
            <router-view></router-view>
        </div>

    </div>
@endsection
