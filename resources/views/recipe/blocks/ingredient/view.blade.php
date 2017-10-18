<section class="group">
    <h3 class="group__title">{{ $groupTitle }}</h3>
    @if ( $group->count() > 0 )
        <ul class="list-checkbox-ingredients">
            @foreach($group as $ingredient)
                <li>@include('recipe.blocks.ingredient.checkbox')</li>
            @endforeach
        </ul>
    @endif
</section>