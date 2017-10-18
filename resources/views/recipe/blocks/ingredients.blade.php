@if ($recipe->getIngredientsCount() > 0)
    @include('partials.separator')

    <section class="recipe-details__ingredients section-ingredients">
        <h2 class="section-ingredients__title">
            @lang('recipe/view.ingredients') <span class="count">({{ $recipe->getIngredientsCount() }})</span>
        </h2>
        {{-- CANCELLED --}}
        {{-- <div class="section-ingredients__switcher">units switcher</div> --}}
        <div class="section-ingredients__box box">
            <div class="ov-hidden">
                <div class="ingredient-groups js-ingredients">
                    @foreach($recipe->getIngredientsGroupTree() as $groupTitle => $group)
                        @include('recipe.blocks.ingredient.view')
                    @endforeach
                </div>
            </div>
        </div>
        @unless (isset($print) && 1 == $print)
        <div class="form-actions">
            <span class="btn-wrap js-save-recipe-ingredients-wrapper">
                @if ($recipe->isSaved())
                    <span class="btn is-purple with-icon is-saved">
                        <span>
                            <svg viewBox="0 0 92.3 88.2" class="icon icon-star">
                                <use xlink:href="#icon-star"></use>
                            </svg>
                            @lang('share.buttons.saved')
                        </span>
                    </span>
                @else
                    {{ Form::button(
                        '<span>
                            <svg viewBox="0 0 92.3 88.2" class="icon icon-star">
                                <use xlink:href="#icon-star"></use>
                            </svg>'
                            . trans('recipe/view.add_recipe_box')
                        . '</span>', [
                        'type' => 'button',
                        'class' => 'btn is-purple with-icon js-add-to-recipe-box',
                        'data-recipe-id' => $recipe->id,
                        'data-error' => trans('recipe/view.recipe_box_error')
                    ]) }}
                @endif
            </span>
            <span class="btn-wrap">
                {{ Form::button(
                    '<span>
                        <svg viewBox="0 0 77.3 91.2" class="icon icon-check">
                            <use xlink:href="#icon-check"></use>
                        </svg>'
                        . '<span class="default">' . trans('recipe/view.select_all') . '</span>'
                        . '<span class="active">' . trans('recipe/view.deselect_all') . '</span>'
                    . '</span>', [
                    'type' => 'button',
                    'class' => 'btn with-icon btn-data-title js-select-all',
                    'data-deselect' => trans('recipe/view.deselect_all'),
                    'data-select' => trans('recipe/view.select_all')
                ]) }}
            </span>
            <span class="btn-wrap">
                {{ Form::button(
                    '<span>
                        <svg viewBox="0 0 1023 767" class="icon icon-basket">
                            <use xlink:href="#icon-basket"></use>
                        </svg>'
                        . trans('recipe/view.add_to_shopping_list')
                    . '</span>', [
                    'type' => 'button',
                    'class' => 'btn is-brown with-icon js-add-to-shopping-list',
                    'data-recipe-id' => $recipe->id,
                    'data-error' => trans('recipe/view.shopping_list_error')
                ]) }}
            </span>


        </div>
        @endunless
    </section>
@endif