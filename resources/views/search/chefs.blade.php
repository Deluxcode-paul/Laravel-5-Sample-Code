@extends('layouts.1column')

@section('content')

    @include('search.blocks.search')

    @include('search.blocks.sections')

    @include('common.blocks.per_page_selector')

    @include('search.chefs.filter')
    @include('search.chefs.sorting')

    @include('common.blocks.per_page_selector')

    <script>
        var json = {
            items: {!! $items->toJson() !!},
            searchResultsCount: {{ $count['chefs'] }},
            hasSearchResults: {!! json_encode($results) !!},
            pagination: '{{ $pagination }}'
        }
    </script>

    @include('search.blocks.no_results')

    <template>
        <a href="@{{ item.publicProfileUrl }}">
            <img v-bind:src="item.listImage" alt="@{{ item.fullName }}">
            <p>Chef @{{ item.fullName }}</p>
            <p>@{{ item.location }} | @{{ item.place_of_work }} | @{{ item.status }}</p>
            <p>@{{ item.bio }}</p>
        </a>
    </template>

@endsection
