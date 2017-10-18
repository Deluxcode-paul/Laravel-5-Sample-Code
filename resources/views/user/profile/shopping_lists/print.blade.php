@extends('layouts.base-print', ['page_class' => 'page-recipe-print'])

@section('title', trans('recipe/view.page_title'))

@section('content')

    <div class="shopping-print">
        <h1 class="maintitle">@lang('user/profile.pdf.shopping_list')</h1>
        @foreach ($shoppingList as $recipe)
            <div class="group">
                <h2 class="title">{{ $recipe->title }}</h2>
                <ul class="list">
                    @foreach ($recipe->ingredients as $ingredient)
                        <li>{!! $ingredient->title !!}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

@endsection