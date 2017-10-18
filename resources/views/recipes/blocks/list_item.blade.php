<li class="item-recipe">
    <a href="{{ $recipe->detailUrl }}" class="item-recipe__wrapper">
        @if ($recipe->icon == 'top_chef')
            <img src="/images/ribbon-recipe.png" alt="" class="item-recipe__ribbon" />
        @endif
        <div class="item-recipe__visual">
            @if ($recipe->videos->count() > 0)
                <span class="item-recipe__video">
                    <svg viewBox="0 0 100 100" class="icon icon-play">
                        <use xlink:href="#icon-play"></use>
                    </svg>
                </span>
            @endif
            <img src="{{ $recipe->getImage('recipe_list_item') }}" class="item-recipe__img" alt="" width="285" height="215" />
        </div>
        <h4 class="item-recipe__title">{{ $recipe->getPreviewTitle() }}<h4>
    </a>
    <div class="item-recipe__meta">
        <a href="{{ $recipe->creatorUrl }}" class="item-recipe__author" title="{{ $recipe->creator }}">{{ $recipe->creator }}</a>
        <div class="item-recipe__time">
            @include('partials.icons.icon-time')
            <span>{{ $recipe->cookingTime }}</span>
        </div>
    </div>
</li>