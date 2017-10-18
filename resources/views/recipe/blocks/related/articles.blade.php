<section class="section-related-articles">
    <div class="site-width">
        <div class="spacer">
            <div class="heading-decorative">
                <h2 class="heading-decorative__title">
                    <span>@lang('recipe/view.related')</span>
                </h2>
                <h3 class="heading-decorative__subtitle">@lang('recipe/view.articles')</h3>
            </div>
            @include('partials.separator', ['type' => 'icon'])
            <ul class="grid with-related">
                @foreach ($relatedArticles as $article)
                    @include('recipe.blocks.related.article_block')
                @endforeach
            </ul>
        </div>
    </div>
</section>