@extends('user.profile.template', [
    'profile_class' => 'profile-shopping'
])

@section('title', trans('titles.profile.shopping_lists'))

@section('profile-breadcrumbs')
    {!! Breadcrumbs::render('user.shopping-lists') !!}
@endsection

@section('profile-section-title')
    @lang('user/profile.sections.shopping_lists')
@endsection

@section('profile-content')
    <section class="section">
        @if (count($shoppingList))
            <div class="headering">
                @include('user.profile.shopping_lists.actions')
                @include('partials.separator')
            </div>
            @include('common.share.mail_form')
            {{ Form::open([
                'url' => route('user.profile.shopping-lists.delete.recipe'),
                'method' => 'POST',
                'class' => 'form-horizontal js-recipe-form',
                'role' => 'form'
            ]) }}
                <div class="shopping__list js-shopping-list-wrapper" data-page="{{ $page }}">
                    @foreach ($shoppingList as $recipe)
                    <div class="shopping__item j-shopping-item">
                        <div class="shopping__checkbox">
                        <label class="form-checkbox">
                            {{ Form::checkbox("recipes[]", $recipe->id, false, [
                                'class' => 'js-recipe-checkbox'
                                ]) }}
                                <span class="form-checkbox__icon">
                                    @include('partials.icons.icon-check')
                                </span>
                            </label>
                        </div>
                        <div class="shopping__expand">
                            <span class="form-checkbox__title shopping__title j-shopping-expand">{{ $recipe->title }}</span>
                            <div class="shopping__sheet">
                                <div class="sheet">
                                    <ul>
                                        @foreach ($recipe->ingredients as $ingredient)
                                            <li>
                                                <span>{!! $ingredient->title !!}</span>
                                                <a href="#"
                                                class="js-delete-ingredient-button delete"
                                                data-id="{{ $ingredient->shopping_list_id }}" title="@lang('user/profile.buttons.delete')">
                                                @include('partials.icons.icon-cross')
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="actions">
                                    <a class="btn is-brown" href="{{ $recipe->detailUrl }}">@lang('user/profile.buttons.see_recipe')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            {{ Form::close() }}
        @else
            <div class="shopping__notify">@lang('user/profile.shopping_list.empty')</div>
        @endif
    </section>
        @if ($paginator->hasPages())
        @include('partials.separator')
    {{ $paginator }}
    @endif
@endsection

@section('inline_script')
    <script>
        Front.routes.delete_recipe = '{{ route('user.profile.shopping-lists.delete.recipe') }}';
        Front.routes.delete_ingredient = '{{ route('user.profile.shopping-lists.delete.ingredient') }}';
        Front.routes.pdf = '{{ route('user.profile.shopping-lists.pdf') }}';
        Front.routes.print = '{{ route('user.profile.shopping-lists.print') }}';
        Front.routes.email = '{{ route('user.profile.shopping-lists.mail') }}';
        Front.translations.no_recipes_selected = '{{ trans('user/profile.js_messages.no_recipes_selected') }}';
        Front.translations.delete_recipe_confirmation = '{{ trans('user/profile.js_messages.delete_recipe_confirmation') }}';
        Front.translations.delete_ingredient_confirmation = '{{ trans('user/profile.js_messages.delete_ingredient_confirmation') }}';
        Front.translations.delete_ingredient_error = '{{ trans('user/profile.js_messages.delete_ingredient_error') }}';
    </script>
@endsection