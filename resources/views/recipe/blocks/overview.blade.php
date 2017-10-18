<section class="recipe-detail__overview j-overview">
    <aside class="aside j-overview-aside">
        <ul class="list-spec">
            @if  ( $recipe->preference()->first()->title )
                <li>
                    <strong class="title">@lang('recipe/view.preference'):</strong>
                    <span class="value">
                        {{ $recipe->preference()->first()->title }}
                    </span>
                </li>
            @endif
            @if ($recipe->getDifficultyLabel())
                <li>
                    <strong class="title">@lang('recipe/view.difficult'):</strong>
                    <span class="value">
                        {{ $recipe->getDifficultyLabel()  }}
                    </span>
                </li>
            @endif
            @if ($recipe->blessingType)
                <li>
                    <strong class="title">@lang('recipe/view.blessing_type'):</strong>
                    <span class="value">
                        {{ $recipe->blessingType->title  }}
                    </span>
                </li>
            @endif
            @if ($recipe->holidays->count() > 0)
                <li>
                    <strong class="title">@lang('recipe/view.occasion'):</strong>
                    <span class="value">
                        {{ $recipe->getHolidaysLabel() }}
                    </span>
                </li>
            @endif
            @if ($recipe->diets->count() > 0)
                <li>
                    <strong class="title">@lang('recipe/view.diet'):</strong>
                    <span class="value">
                        {{ $recipe->getDietsLabel() }}
                    </span>
                </li>
            @endif
            @if ($recipe->sources->count() > 0)
                <li>
                    <strong class="title">@lang('recipe/view.sources'):</strong>
                    <span class="value">
                        {{ $recipe->getSourceLabel() }}
                    </span>
                </li>
            @endif
            @if ($recipe->cuisines->count() > 0)
                <li>
                    <strong class="title">@lang('recipe/view.cuisines'):</strong>
                    <span class="value">
                        {{ $recipe->getCuisinesLabel() }}
                    </span>
                </li>
            @endif
        </ul>
    </aside>
    <div class="content">
        <div class="recipe-detail__descr j-overview-descr">
            {{ $recipe->description }}
            <button class="link j-more">@lang('recipe/view.read_more')</button>
        </div>
    </div>
</section>