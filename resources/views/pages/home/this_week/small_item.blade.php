<li class="item-recipe">
    <a href="{{ $recipe->detailUrl }}" class="item-recipe__wrapper">
        {{-- TODO: Icon for Top/Community Chefs’ recipes. --}}
        @if ($recipe->icon == 'top_chef')
            <img src="/images/ribbon-recipe.png" alt="" class="item-recipe__ribbon" />
        @elseif ($recipe->icon == 'community_chef')
            {{--<img src="/images/ribbon-recipe.png" alt="" class="item-recipe__ribbon" />--}}
        @endif
        <div class="item-recipe__visual">
            @if ($recipe->videos->count() > 0)
                <span class="item-recipe__video">
                    <svg viewBox="0 0 100 100" class="icon icon-play">
                        <use xlink:href="#icon-play"></use>
                    </svg>
                </span>
            @endif
            <img src="{{ $recipe->getImage('recipe_list_item') }}" class="item-recipe__img" alt="" />
        </div>
        <div class="item-recipe__status">
            @if ($recipe->hasAttribute('views'))
                @lang('pages/home.labels.most_viewed')
            @elseif ($recipe->hasAttribute('shares'))
                @lang('pages/home.labels.most_shared')
            @endif
        </div>
        <h4 class="item-recipe__title">{{ $recipe->title }}<h4>
    </a>
    <div class="item-recipe__meta">
        <a href="{{ $recipe->creatorUrl }}" class="item-recipe__author">
            {{ $recipe->creator }}
        </a>
        <div class="item-recipe__time">
            @include('partials.icons.icon-time')
            <span>{{ $recipe->cookingTime }}</span>
        </div>
    </div>
</li>
