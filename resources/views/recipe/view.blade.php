@extends('layouts.1column', [
    'page_class' => 'page-detail'
])

@section('title', $recipe->title . ' | ' . trans('titles.recipes'))

@push('footer_js')
<script src="{{ URL('/') }}/js/details.js"></script>
@endpush

@section('content')
    <div class="recipe-detail">

        <!-- Begin Recipe Heading -->
        <section class="section-heading"
                 style="background-image: url('{{ $recipe->getBlurredImage('details.cover') }}')">
            <div class="site-width">
                <div class="section-spacer">
                    {!! Breadcrumbs::render('recipe', $recipe) !!}
                </div>
            </div>
        </section>
        <!-- End Recipe Heading -->

        <div class="recipe-detail-container site-width">
            <div class="section-shift">
                <div class="recipe-detail-main">

                    <h1 class="recipe-detail__title">{{ $recipe->title }}</h1>

                    <div class="recipe-detail__author">
                        <a href="{{ $user->publicProfileUrl }}"><img src="{{ $user->getImage() }}" alt="{{ $user->fullName }}"></a>
                        @lang('recipe/view.recipe_by')
                        <a href="{{ $user->publicProfileUrl }}">{{ $user->fullName }}</a>
                    </div>
                    <!-- Begin Recipe gallery -->
                    @include('recipe.blocks.gallery')
                    <!-- End Recipe gallery -->

                    <!-- Begin Recipe Stat -->
                    @include('recipe.blocks.stats')
                    <!-- End Recipe Stat -->

                    <!-- Begin Overview -->
                    @include('recipe.blocks.overview')
                    <!-- End Overview -->

                    <!-- Begin Ingredients -->
                    @include('recipe.blocks.ingredients')
                    <!-- End Ingredients -->

                    @include('partials.separator')

                    <!-- Begin Cooking Steps -->
                    @include('recipe.blocks.cooking_steps')
                    <!-- End Cooking Steps -->

                    <!-- Begin Tags Steps -->
                    @if ($recipe->tags->count() > 0)
                        <div class="tags">
                            <strong>@lang('recipe/view.tags'):</strong>
                            <ul>
                                @foreach($recipe->tags as $tag)
                                    <li>
                                        <a href="{{ $recipe->getSearchUrl($tag->title) }}"
                                           title="{{ $tag->title }}">{{ $tag->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- End Tags Steps -->
                    
                    <!-- Begin Sharing Toolbar -->
                        @include('recipe.blocks.toolbar')
                    <!-- End Sharing Toolbar -->

                    <div class="community-block box-tabs js-responsive-tabs">
                        <ul class="tabset uppercase">
                            <li><a href="#questions">@lang('recipe/questions.questions_title')</a></li>
                            <li><a href="#reviews">@lang('recipe/review.reviews_title')</a></li>
                        </ul>

                        <div class="tab" id="questions">
                            <!-- Begin Review Section -->
                            @include('recipe.blocks.questions.index')
                            <!-- End Review Section -->
                        </div>

                        <div class="tab" id="reviews">
                            <!-- Begin Review Section -->
                            @include('recipe.blocks.reviews.index')
                            <!-- End Review Section -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-after')
    @if ($relatedRecipes->count() > 0)
        @include('recipe.blocks.related.recipes')
    @endif

    @if ($relatedArticles->count() > 0)
        @include('recipe.blocks.related.articles')
    @endif

    @parent
@endsection

@section('inline_script')
    @parent
    <script>
        Front.routes.share = '{{ route('recipe.share', $recipe->id) }}';
        Front.routes.email = '{{ route('recipe.mail', $recipe->id) }}';
    </script>
@endsection

@include('user.profile.activity.blocks.inline_script')

@section('bfm-share-tags')
    @include('bfm-share::meta_tags', [
        'url' => $recipe->detailUrl,
        'title' => $recipe->title,
        'description' => str_limit(strip_tags($recipe->description), 300),
        'imageUrl' => $recipe->getImage('open_graph'),
        'imageSecureUrl' => BfmImage::init($recipe->image)->secure()->get('open_graph')
    ])
@endsection
