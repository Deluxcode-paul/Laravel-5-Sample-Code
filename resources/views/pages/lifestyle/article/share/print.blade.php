@extends('layouts.base-print', ['page_class' => 'page-recipe-print'])

@section('title', trans('recipe/view.page_title'))

@section('content')
    <div class="article-print">
        <img class="img" src="{{ $article->getImage('article_view') }}" />
        <div class="header">
            <span class="category">{{ $article->category->title }}</span>
            <h1 class="title">{{ $article->title }}</h1>
            <div class="meta">
                <span>{{ $article->published }}</span> | <i>{{ $article->user->fullName }}</i>
            </div>
        </div>
        <div class="content">
            {!! $article->content !!}
        </div>

        @if ($article->tags->count() > 0)
            <div class="tags">
                @lang('pages/article.headings.tags'): "{{ $article->tags->implode('title', '", "') }}"
            </div>
        @endif
    </div>
@endsection