@extends('layouts.1column', ['page_class' => 'page-listing'])

@section('content')

    <div id="vue-app">
        <router-view></router-view>
    </div>

    <div class="listing-wrapper {{ isset($listing_wrapper_class) ? $listing_wrapper_class : 'is-subcategory' }}" id="js-listing">

        @include('common.page-heading', [
            'bg' => '/images/bg-subcategory.jpg',
            'title0' => 'Recipes111',
            'title1' => $header
        ])

        <script>
            var listing_json = {!! $results !!};
        </script>

        <router-view></router-view>

        <div class="listing">
            <div class="site-width">
                <div class="listing__spacer">
                    <aside class="listing__aside">
                        @include('recipes.list.sidebar')
                    </aside>
                    <div class="listing__container">
                        @include('recipes.list.top')
                        @include('recipes.list.selected')
                        @include('recipes.list.list')
                        @include('recipes.list.bottom')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('cta')
@endsection