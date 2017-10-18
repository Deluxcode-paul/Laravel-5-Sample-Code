@extends('layouts.1column', [
    'page_class' => 'page-chefs'
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/chef.js"></script>
@endpush

@section('title', $user->fullName . ' | ' . trans('titles.chefs'))

@section('content')
    <div class="chef">
        <section class="page-heading" style="background-image: url('{{ URL('/') }}/images/bg-chef.jpg');">
            <div class="site-width">
                {!! Breadcrumbs::render('chef', $user) !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title">
                            <span>
                                @if ($user->isTopChef())
                                    @lang('user/profile.headings.top_chef')
                                @else
                                    @lang('user/profile.headings.community_chef')
                                @endif
                            </span>
                        </h1>
                        <h2 class="heading-decorative__subtitle">{{ $user->fullName }}</h2>
                    </div>
                </div>
            </div>
        </section>

        <div class="chef__header">
            <div class="site-width">
                @include('user.public_profile.view.about')
                @if ($user->facebook || $user->instagram || $user->pinterest || $user->youtube || $user->twitter || $user->website)
                    @include('user.public_profile.view.social')
                @endif
                <div class="actions-nav j-action-share">
                    @include('user.public_profile.view.actions')
                </div>
            </div>
        </div>
        @if ($user->recipes->count() || $user->articles()->published()->count() || $videos->count() || $articleComments->count() || $communityQuestions->count() || $recipeQuestions->total() || $recipeReviews->total())
            <div class="chef__content">
                <div class="site-width">
                    <div class="box-tabs js-responsive-tabs">
                        @include('user.public_profile.view.menu')

                        @include('user.public_profile.view.recipes')
                        @include('user.public_profile.view.articles')
                        @include('user.public_profile.view.videos')
                        @include('user.public_profile.view.comments')
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('inline_script')
    @parent
    <script>
        Front.routes.get_recipes = '{{ route('user.ajax.recipes', ['user' => $user->id]) }}';
        Front.routes.get_articles = '{{ route('user.ajax.articles', ['user' => $user->id]) }}';
        Front.routes.get_videos = '{{ route('user.ajax.videos', ['user' => $user->id]) }}';
        Front.routes.get_article_comments = '{{ route('user.ajax.article-comments', ['user' => $user->id]) }}';
        Front.routes.get_community_questions = '{{ route('user.ajax.community-questions', ['user' => $user->id]) }}';
        Front.routes.get_recipe_questions = '{{ route('user.ajax.recipe-questions', ['user' => $user->id]) }}';
        Front.routes.get_recipe_reviews = '{{ route('user.ajax.recipe-reviews', ['user' => $user->id]) }}';
        Front.routes.email = '{{ route('user.ajax.mail', ['user' => $user->id]) }}';
        Front.translations.load_recipes_error = '{{ trans('user/profile.js_messages.load_recipes_error') }}';
        Front.translations.load_articles_error = '{{ trans('user/profile.js_messages.load_articles_error') }}';
        Front.translations.load_videos_error = '{{ trans('user/profile.js_messages.load_videos_error') }}';
        Front.translations.load_article_comments_error = '{{ trans('user/profile.js_messages.load_article_comments_error') }}';
        Front.translations.load_community_questions_error = '{{ trans('user/profile.js_messages.load_community_questions_error') }}';
        Front.translations.load_recipe_questions_error = '{{ trans('user/profile.js_messages.load_recipe_questions_error') }}';
        Front.translations.load_recipe_reviews_error = '{{ trans('user/profile.js_messages.load_recipe_reviews_error') }}';
    </script>
@endsection

@include('user.profile.activity.blocks.inline_script')

@section('bfm-share-tags')
    @include('bfm-share::meta_tags', [
        'url' => $user->detailUrl,
        'title' => $user->fullName,
        'description' => str_limit(strip_tags($user->bio), 300),
        'imageUrl' => $user->getImage('open_graph'),
        'imageSecureUrl' => BfmImage::init($user->image)->secure()->get('open_graph')
    ])
@endsection
