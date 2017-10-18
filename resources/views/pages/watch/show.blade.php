@extends('layouts.1column', [
    'page_class' => 'page-show'
])

@section('title', $show->title . ' | ' . trans('titles.watch'))

@section('content')

    <div class="show">
        <div class="show__banner">
            @include('pages.watch.show.details')
        </div>
        <script>
            var trans = {!! json_encode($labels) !!},
                json = {!! $results !!};

            json.noResults = {!! $noResults !!};
        </script>
        <div id="vue-app" class="show__listing">
            <router-view></router-view>
        </div>
    </div>

@endsection