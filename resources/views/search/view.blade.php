@extends('layouts.1column', [
    'page_class' => 'page-search'
])

@section('content')

    @section('content-data')
        <script>
            var trans = {!! json_encode($labels) !!},
                json = {!! $results !!};

            json.noResults = {!! $noResults !!};
            json.tabs = {!! $tabs !!};
        </script>
    @show

    <div class="search">
        @include('search.blocks.search')
        <div id="vue-app">
            <router-view></router-view>
        </div>
    </div>

@endsection