<section class="section-related-recipes">
    <div class="site-width">
        <div class="spacer">
            <div class="heading-decorative">
                <h2 class="heading-decorative__title">
                    <span>@lang('recipe/view.related')</span>
                </h2>
                <h3 class="heading-decorative__subtitle">@lang('recipe/view.recipes')</h3>
            </div>
            @include('partials.separator', ['type' => 'icon'])
            <ul class="grid {{ count($relatedRecipes) < 4 ? 'is-centered' : '' }}">
                @foreach ($relatedRecipes as $recipe)
                    @include('recipes.blocks.list_item')
                @endforeach
            </ul>
        </div>
    </div>
</section>