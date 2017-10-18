@extends('layouts.1column', ['page_class' => 'page-community-lp'])

@section('title', trans('titles.community'))

@section('content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.popularTags = {!! json_encode($popularTags) !!};
        json.popularItems = {!! json_encode($popularItems) !!};
        json.askUrl = '{{ route('community.ask-question') }}';

    </script>

    <div class="community-lp">
        <section class="page-heading" style="background-image: url('{{ url('images/bg-community.jpg') }}');">
            <div class="site-width">
            {!! Breadcrumbs::render('community') !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title"><span>@lang('community.headings.kosher')</span></h1>
                        <h2 class="heading-decorative__subtitle">@lang('community.headings.community')</h2>
                    </div>
                    @include('community.blocks.search')
                </div>
            </div>
        </section>
        <section class="community-lp__content">

            <div id="vue-app">
                <router-view></router-view>
            </div>

{{--             <div class="site-width">
                <div class="community-lp__actions">
                    <a class="btn is-purple" href="{{ route('community.ask-question') }}">
                        @lang('community.buttons.ask_a_question')
                    </a>
                </div>
                <div class="community-lp__wrapper">
                    <section class="community-lp__main">

                    </section>
                    <aside class="community-lp__aside">
                        <div class="aside">
                            @include('community.blocks.sidebar.popular_tags')
                            @include('community.blocks.sidebar.popular_items')
                        </div>
                    </aside>
                </div>
            </div> --}}
        </section>
    </div>
@endsection