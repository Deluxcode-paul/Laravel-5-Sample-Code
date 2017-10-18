@extends('layouts.1column', [
    'page_class' => 'page-article'
])

@section('title', $article->title . ' | ' .trans('titles.lifestyle'))

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/article.js"></script>
@endpush

@section('content')
    <div class="article">
        <div class="article__breadcrumb">
            <div class="site-width">
                {!! Breadcrumbs::render('article', $article) !!}
            </div>
        </div>
        <div class="site-width">
            <div class="article__wrapper">
                <section class="article__content">
                    <div class="article__item">
                        <div class="actions">
                            <a class="link-arrow" href="{{ route('lifestyle') }}">@lang('pages/article.buttons.go_back')</a>
                        </div>
                        @if ($article->hasVideo)
                            <a class="img" href="{{ $article->videos()->first()->getUrl() }}">
                                <span class="video">
                                    <svg viewBox="0 0 100 100" class="icon icon-play">
                                        <use xlink:href="#icon-play"></use>
                                    </svg>
                                </span>
                                <img src="{{ $article->getImage('article_view') }}" />
                            </a>
                        @else
                            <div class="img">
                                <img src="{{ $article->getImage('article_view') }}" />
                            </div>
                        @endif


                        <div class="header">
                            <a href="{{ $article->getCategoryUrl() }}" class="category">{{ $article->category->title }}</a>
                            <h1 class="title">{{ $article->title }}</h1>
                            <div class="meta">
                                <span>{{ $article->published }}</span> | <a href="{{ $article->user->publicProfileUrl }}">{{ $article->user->fullName }}</a>
                            </div>
                        </div>
                        <div class="content">{!! $article->content !!}</div>
                        <div class="tags">
                            @if ($article->tags->count())
                                <ul>
                                    @foreach ($article->tags as $tag)
                                        <li><a href="{{ $article->getSearchUrl($tag->title) }}">{{ $tag->title }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="actions">
                            <a class="link-arrow" href="{{ route('lifestyle') }}">@lang('pages/article.buttons.go_back')</a>
                        </div>
                        <div class="actions-nav j-action-share">
                            @include('pages.lifestyle.article.actions')
                        </div>
                    </div>
                    <!-- Begin Review Section -->
                    <div class="community-block box-tabs js-responsive-tabs">
                        @include('pages.lifestyle.article.comments.index')
                    </div>
                    <!-- End Review Section -->
                </section>
                @if ($relatedArticles->count())
                    <aside class="article__aside">
                        <div class="aside">
                            @include('pages.lifestyle.article.related')
                        </div>
                    </aside>
                @endif
            </div>
        </div>

    </div>
@endsection


@section('inline_script')
    @parent
    <script>
        Front.routes.print = '{{ route('article.print', ['article' => $article->id]) }}';
        Front.routes.email = '{{ route('article.mail', ['article' => $article->id]) }}';
        Front.routes.share = '{{ route('article.share', ['article' => $article->id]) }}';
    </script>
@endsection

@include('user.profile.activity.blocks.inline_script')

@section('bfm-share-tags')
    @include('bfm-share::meta_tags', [
        'url' => $article->getUrl(),
        'title' => $article->title,
        'description' => str_limit(strip_tags($article->content), 300),
        'imageUrl' => $article->getImage('open_graph'),
        'imageSecureUrl' => BfmImage::init($article->image)->secure()->get('open_graph')
    ])
@endsection
