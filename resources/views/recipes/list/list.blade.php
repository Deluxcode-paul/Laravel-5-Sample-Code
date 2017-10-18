<div class="listing__content">
    <ul class="grid">
        @foreach($recipes as $recipe)
            @include('recipes.blocks.list_item')
        @endforeach
    </ul>
</div>