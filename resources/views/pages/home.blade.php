@extends('layouts.1column', [
    'page_class' => 'page-home',
    'cta' => 1
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/home.js"></script>
@endpush

@section('content')
    <div class="home">

        @if ($bannerItems->count())
            @include('pages.home.banner')
        @else
            <div class="banner-dump"></div>
        @endif

        @include('pages.home.search')

        @if ($newestRecipes->count())
            @include('pages.home.in_our_kitchen')
        @endif
        @if ($archivedRecipes->count())
            @include('pages.home.from_the_archives')
        @endif
        @if ($mainThisWeekRecipes->count() || $thisWeekRecipes->count())
            @include('pages.home.this_week')
        @endif
        @if ($mainArticle || $articles->count())
            @include('pages.home.explore_lifestyle')
        @endif
        @if ($community->count())
            @include('pages.home.our_community')
        @endif
        @if ($chefs->count())
            @include('pages.home.our_chefs')
        @endif
    </div>

@endsection

@include('user.profile.activity.blocks.inline_script')