@extends('layouts.1column', [
    'page_class' => 'page-category',
    'cta' => 1
])

@section('title', trans('titles.recipes'))

@section('content')

    <div class="category">
        @include('recipes.category.heading')
        <div class="category-main site-width">
            @include('recipes.category.featured_categories')
            @include('recipes.category.categories')
            @include('partials.separator')
            @include('recipes.category.holidays')
        </div>

    </div>

@endsection

@section('content-after')

    @include('recipes.category.featured_recipes')

    @parent

@endsection