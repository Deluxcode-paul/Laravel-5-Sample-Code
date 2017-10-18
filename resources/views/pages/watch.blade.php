@extends('layouts.1column', [
    'page_class' => 'page-watch'
])

@section('title', trans('titles.watch'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('watch') !!}
@endsection

@section('content')
    <div class="watch">
        <section class="watch__header">
            <div class="page-heading">
                <div class="site-width">
                    {!! Breadcrumbs::render('watch') !!}
                    <div class="page-heading__spacer">
                        <div class="heading-decorative">
                            <h1 class="heading-decorative__title">@lang('pages/watch.headings.kosher')</h1>
                            <h2 class="heading-decorative__subtitle">@lang('pages/watch.headings.watch')</h2>
                        </div>
                        <span class="video">
                            <svg viewBox="0 0 100 100" class="icon icon-play">
                                <use xlink:href="#icon-play"></use>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            @if ($bannerVideos->count())
                @include('pages.watch.banner')
            @endif
        </section>

        @if ($shows->count())
            <section class="watch__slider">
                <div class="site-width">
                    <h2 class="title">@lang('pages/watch.headings.kosher_shows')</h2>
                    @include('pages.watch.shows')
                </div>
            </section>
        @endif

        <script>
            var trans = {!! json_encode($labels) !!},
                json = {!! $results !!};

            json.noResults = {!! $noResults !!};
        </script>
        <div id="vue-app" class="watch__listing">
            <router-view></router-view>
        </div>

    </div>

@endsection