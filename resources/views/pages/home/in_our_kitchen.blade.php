<section class="our-kitchen" style="background-image: url('{{ URL('/') }}/images/home/bg-ourkitchen.jpg');">
    <div class="site-width">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('pages/home.headings.in_our')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.kitchen')</h3>
        </div>
        @include('partials.separator', ['type' => 'icon'])
        <span class="category">@lang('pages/home.headings.the_newest')</span>
        <ul class="grid grid-row4_5 {{ count($newestRecipes) < 4 ? 'is-centered' : '' }}">
            @foreach($newestRecipes as $recipe)
                @include('recipes.blocks.list_item')
            @endforeach
        </ul>
        <div class="actions a-center">
            <a href="{{ KosherHelper::getNewestRecipesUrl() }}" class="btn is-purple">@lang('pages/home.buttons.see_all_new_recipes')</a>
        </div>
    </div>
</section>