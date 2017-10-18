@extends('layouts.1column')

@section('content')

    @include('search.blocks.search')

    @include('search.blocks.sections')

    @include('common.blocks.per_page_selector')

    @include('search.watch.filter')
    @include('search.watch.sorting')

    @include('common.blocks.per_page_selector')

    <script>
        var json = {
            items: {!! $items->toJson() !!},
            searchResultsCount: {{ $count['watch'] }},
            hasSearchResults: {!! json_encode($results) !!},
            pagination: '{{ $pagination }}'
        }
    </script>

    @include('search.blocks.no_results')

    <template>
        <a href="@{{ item.detailsUrl }}">
            <img v-bind:src="item.listImage" alt="@{{ item.title }}">
            <p>@{{ item.title }}</p>
            <p>@{{ item.creator }}</p>
        </a>
    </template>

@endsection
