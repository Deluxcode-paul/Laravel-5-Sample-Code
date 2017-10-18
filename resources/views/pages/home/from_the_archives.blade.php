<section class="archive">
    <div class="site-width">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('pages/home.headings.from_the')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.archives')</h3>
        </div>
        @include('partials.separator', ['type' => 'icon'])
        <ul class="grid {{ count($archivedRecipes) < 4 ? 'is-centered' : '' }}">
            @foreach($archivedRecipes as $recipe)
                @include('recipes.blocks.list_item')
            @endforeach
        </ul>
    </div>
</section>