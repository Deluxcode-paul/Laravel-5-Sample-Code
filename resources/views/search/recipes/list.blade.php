@extends('search.view')

@section('title', trans('titles.search.recipes'))

@section('content-data')
    @parent
    <script>
        json.ingredients = {!! $ingredients !!};

        // urls for autocomplete
        json.chefsUrl = '{{ URL('/') }}' + '/search/chefs';
    </script>
@endsection