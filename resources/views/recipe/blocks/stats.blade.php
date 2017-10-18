<ul class="list-stats">
    <li>
        <strong>@lang('recipe/view.cook_prep'):</strong>
        @include('partials.icons.icon-time')
        <span class="value">{{ $recipe->cookingTime }}</span>
    </li>
    <li>
        <strong>@lang('recipe/view.serving'):</strong>
        @include('partials.icons.icon-pot')
        <span class="value">{{ $recipe->serving }}</span>
    </li>
    <li>
        @if ($allergens->count() > 0)
            <strong>@lang('recipe/view.contains'):</strong>
            <ul class="list-allergens">
                @foreach($allergens as $allergen)
                    <li title="{{ $allergen->title }}">
                        @include('partials.icons.allergens.icon-' . $allergen->id)
                    </li>
                @endforeach
            </ul>
        @else
            <div class="value">{{ trans('recipe/view.no_allergens') }}</div>
        @endif
    </li>
</ul>