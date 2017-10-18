@extends('layouts.1column', [
    'page_class' => 'page-subcategory'
])

@section('title', trans('titles.subcategory_landing'))

@section('content')

    <script>
        var trans = {!! json_encode($labels) !!},
            json = {!! $results !!};

        json.noResults = {!! $noResults !!};

        // static image
        json.header_bg = '{{ URL('/') }}' + '/images/bg-subcategory.jpg';

        json.ingredients = {!! $ingredients !!};

    </script>

    <div id="vue-app">
        <router-view></router-view>
    </div>

@endsection