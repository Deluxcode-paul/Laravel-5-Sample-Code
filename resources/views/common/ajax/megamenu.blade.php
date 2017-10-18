<div class="megamenu__container">
    <div class="megamenu__items">
        <div class="megamenu__categories">
            @if ($categories->count())
            <ul class="list-category-circles">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ $category->getSubCategoryUrl() }}">
                            <span class="img">
                                <img src="{{ $category->getImage('recipe_category_megamenu') }}" alt="{{ $category->title }}" />
                            </span>
                            <span class="title">{{ $category->title }}</span>
                        </a>
                    </li>
                @endforeach
                <li>
                    <a href="{{ route('recipes.category') }}">
                        <span class="img">
                            <span>@lang('common/header.megamenu.see_all_categories')</span>
                        </span>
                    </a>
                </li>
            </ul>
            @endif
        </div>
        <div class="megamenu__holidays">
            <h2>@lang('common.holidays')</h2>
            @if ($holidays->count())
                <ul class="list-category">
                    @foreach($holidays as $holiday)
                        <li>
                            <a href="{{ $holiday->getSubCategoryUrl() }}" title="{{ $holiday->title }}">
                                <img src="{{ $holiday->getImage('recipe_category_recipes_common') }}" alt="{{ $holiday->title }}" />
                                <span>{{ $holiday->title }}</span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('recipes.category') }}">
                            <img src="{{ URL('/') }}/images/img-holidays-all.jpg" alt="{{ trans('common/header.megamenu.view_all') }}">
                            <span>@lang('common/header.megamenu.view_all')</span>
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
    <div class="megamenu__cta" style="background-image: url('{{ URL('/') }}/images/bg-megamenu-cta.jpg');">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('common/header.megamenu.cta.heading')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('common/header.megamenu.cta.question')</h3>
        </div>
        <div class="descr">@lang('common/header.megamenu.cta.descr')</div>
        <a href="{{ route('generate-a-meal') }}" class="btn is-brown">@lang('common/header.megamenu.cta.button_title')</a>
    </div>
</div>