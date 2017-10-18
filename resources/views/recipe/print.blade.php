@extends('layouts.base-print', ['page_class' => 'page-recipe-print'])

@section('title', trans('recipe/view.page_title'))

@section('content')
    <div class="recipe-print">
        <div class="recipe-print__header">
            <h1 class="title">{{ $recipe->title }}</h1>
            <div class="author">
                @lang('recipe/view.recipe_by')
                <span>{{ $user->fullName }}</span>
            </div>
            <div class="img">
                <img src="{{ $recipe->getImage('details.slide') }}" alt="">
            </div>
        </div>

        <table class="list-stats">
            <tr>
                <td>
                    <div>
                        <strong>@lang('recipe/view.cook_prep'):</strong>
                        @include('partials.icons.icon-time')
                        <span class="value">{{ $recipe->cookingTime }}</span>
                    </div>
                </td>
                <td>
                    <div>
                        <strong>@lang('recipe/view.serving'):</strong>
                        @include('partials.icons.icon-pot')
                        <span class="value">{{ $recipe->serving }}</span>
                    </div>
                </td>
                <td>
                    @if ($allergens->count() > 0)
                        <div>
                            <strong>@lang('recipe/view.contains'):</strong>
                            <ul class="list-allergens">
                                @foreach($allergens as $allergen)
                                    <li title="{{ $allergen->title }}">
                                        @include('partials.icons.allergens.icon-' . $allergen->id)
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="value">{{ trans('recipe/view.no_allergens') }}</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td height=10 colspan="3"></td>
            </tr>
        </table>

        @include('recipe.blocks.overview')

        @include('recipe.blocks.ingredients', ['print' => 1])

        @include('recipe.blocks.cooking_steps', ['print' => 1])

        @if ($recipe->tags->count() > 0)
            <div class="tags">
                @lang('recipe/view.tags'): "{{ $recipe->tags->implode('title', '", "') }}"
            </div>
        @endif
    </div>
@endsection