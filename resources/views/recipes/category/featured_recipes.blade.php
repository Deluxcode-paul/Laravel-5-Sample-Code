@if ($featuredRecipes->count())
    <section class="section-featured-recipes">
        <div class="site-width">
            <div class="spacer">
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title">
                        <span>@lang('common.featured_recipes.0')</span>
                    </h1>
                    <h2 class="heading-decorative__subtitle">@lang('common.featured_recipes.1')</h2>
                </div>
                @include('partials.separator', ['type' => 'icon'])
                <ul class="grid {{ count($featuredRecipes) < 4 ? 'is-centered' : '' }}">
                    @foreach($featuredRecipes as $recipe)
                        @include('recipes.blocks.list_item')
                    @endforeach
                </ul>
                <div class="actions a-center">
                    <a href="{{ KosherHelper::getFeaturedRecipesUrl() }}" class="btn is-purple">@lang('recipes/list.view_all_recipes')</a>
                </div>
            </div>
        </div>
    </section>
@endif