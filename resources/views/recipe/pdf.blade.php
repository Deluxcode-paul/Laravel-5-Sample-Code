@extends('layouts.base-pdf', ['page_class' => 'page-recipe-pdf'])

@section('title', trans('recipe/view.page_title'))

@section('content')
    <div class="recipe-pdf">
        <div class="recipe-pdf__header">
            <h1 class="title">{{ $recipe->title }}</h1>
            <div class="author">
                @lang('recipe/view.recipe_by')
                <span>{{ $user->fullName }}</span>
            </div>
            <div class="img">
                <img src="{{ $recipe->getImage('details.slide') }}" alt="">
            </div>
        </div>

        <div class="list-stats">
            <table>
                <tr><td colspan="3" height="10"></td></tr>
                <tr>
                    <td width="200" align="center">
                        <span class="title">
                            <strong>@lang('recipe/view.cook_prep'):</strong>
                            <img src="{{ URL('/images/icons/icon-time.png') }}" class="icon icon-time" alt="">
                            <span class="value">{{ $recipe->cookingTime }}</span>
                        </span>
                    </td>
                    <td width="100" align="center">
                        <span class="title">
                            <strong>@lang('recipe/view.serving'):</strong>
                            <img src="{{ URL('/images/icons/icon-pot.png') }}" class="icon icon-time" alt="">
                            <span class="value">{{ $recipe->serving }}</span>
                        </span>
                    </td>
                    <td>
                        @if ($allergens->count() > 0)
                            <span class="title">
                                <strong>@lang('recipe/view.contains'):</strong>
                            </span>
                            @foreach($allergens as $allergen)
                                <img src="{{ URL('/images/icons/allergens/icon-' . $allergen->id . '.png') }}" class="icon icon-allergen-{{ $allergen->id }}" alt="">
                            @endforeach
                        @else
                            <span class="title">
                                <strong>{{ trans('recipe/view.no_allergens') }}</strong>
                                <img src="{{ URL('/images/icons/icon-time.png') }}" class="icon icon-opacity" alt="">
                            </span>
                        @endif
                    </td>
                </tr>
                <tr><td colspan="3" height="10"></td></tr>
            </table>
        </div>

        <div class="recipe-detail__overview">
            <div class="aside">
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
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                </ul>
            </div>
            <div class="content">
                @if ($recipe->description)
                    <div class="recipe-detail__descr">{{ $recipe->description }}</div>
                @endif
            </div>
        </div>

        @if ($recipe->getIngredientsCount() > 0)
            <div class="recipe-details__ingredients section-ingredients">
                <h2 class="section-ingredients__title">
                    @lang('recipe/view.ingredients') <span class="count">({{ $recipe->getIngredientsCount() }})</span>
                </h2>
                <div class="section-ingredients__box box">
                    <div class="ov-hidden">
                        <div class="ingredient-groups js-ingredients">
                            @foreach($recipe->getIngredientsGroupTree() as $groupTitle => $group)
                                <section class="group">
                                <h3 class="group__title">{{ $groupTitle }}</h3>
                                @if ( $group->count() > 0 )
                                    <ul class="list-checkbox-ingredients">
                                        @foreach($group as $ingredient)
                                            <li>
                                                <label class="form-checkbox">
                                                    <span class="form-checkbox__icon"></span>
                                                    <span class="form-checkbox__title">{!! $ingredient->description !!}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </section>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($recipe->cooking->count())
            <div class="recipe-details__steps section-steps">
                <div class="section-steps__heading">
                    <h2 class="section-steps__title">@lang('recipe/view.start_cooking')</h2>
                </div>
                <div class="section-steps__box box js-steps">
                    @foreach($recipe->cooking as $cooking)
                        <section class="step">
                            <h3 class="step__title">{{ $cooking->title }}</h3>
                            <div class="step__content">
                                <div class="step__descr">{!! $cooking->description !!}</div>
                                @if($cooking->steps->count())
                                    <ol>
                                        @foreach($cooking->steps()->orderBy('lft', 'asc')->get() as $step)
                                            <li>
                                                <div class="counter">{{$loop->iteration}}.</div>
                                                {!! $step->description !!}
                                                @unless(empty($step->image))
                                                    <div class="center">
                                                        <img src="{{ $step->getImage() }}" alt="{{ $cooking->title }}" />
                                                    </div>
                                                @endunless
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </div>
                            @unless(empty($cooking->note) && empty($cooking->tip) && empty($cooking->variation))
                                <div class="step__additional">
                                    @unless(empty($cooking->note))
                                        <div class="row">
                                            <strong>@lang('recipe/view.note'):</strong>
                                            {!! $cooking->note !!}
                                        </div>
                                    @endunless
                                    @unless(empty($cooking->tip))
                                        <div class="row">
                                            <strong>@lang('recipe/view.tip'):</strong>
                                            {!! $cooking->tip !!}
                                        </div>
                                    @endunless
                                    @unless(empty($cooking->variation))
                                        <div class="row">
                                            <strong>@lang('recipe/view.variation'):</strong>
                                            {!! $cooking->variation !!}
                                        </div>
                                    @endunless
                                </div>
                            @endunless
                        </section>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
