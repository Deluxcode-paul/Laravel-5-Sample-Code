@extends('layouts.1column', [
    'page_class' => 'page-video'
])

@section('title', $video->title . ' | ' . trans('titles.watch'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('video', $video) !!}
@endsection

@section('content')
    <div class="video-detail">
        <section class="section-heading" style="background-image: url('{{ $video->getBlurredImage('video.cover')  }}')">
            <div class="site-width">
                <div class="section-spacer">
                    {!! Breadcrumbs::render('video', $video) !!}
                </div>
            </div>
        </section>
        <div class="video-detail-container site-width">
            <div class="section-shift">
                <div class="video-detail-main">
                    <h1 class="video-detail__title">{{ $video->title }}</h1>
                    <div class="video-detail__author">
                        <a href="{{ $video->creatorUrl }}"><img src="{{ $video->creatorImage }}" alt="{{ $video->creator }}"></a>
                        @lang('pages/video.view.video_by')
                        <a href="{{ $video->creatorUrl }}">{{ $video->creator }}</a>
                    </div>
                    <section class="section-video">
                        <div class="section-video__container">
                            <iframe width="926" height="520" src="{{ $video->getEmbedUrl() }}" frameborder="0" ></iframe>
                        </div>
                    </section>
                    <section class="video-description">
                        <div class="actions">
                           <a class="link" href="{{ $video->ownerUrl }}">{{ $video->ownerUrlText }}</a>
                        </div>
                        <div class="video-description__content">
                           <p>{{ $video->description }}</p>
                        </div>
                        <div class="video-description__tags">
                            @if ($video->tags->count())
                                <strong>@lang('pages/video.labels.tags')</strong>
                                <ul>
                                    @foreach($video->tags as $tag)
                                        <li>
                                            <a href="{{ $video->getSearchUrl($tag->title) }}">
                                                {{ $tag->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="actions-nav j-action-share">
                            @include('pages.watch.video.actions')
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('inline_script')
    <script>
        Front.routes.save = '{{ route('user.recipe-box.add') }}';
        Front.routes.email = '{{ route('watch.video.mail', ['video' => $video->id]) }}';
    </script>
@endsection

@section('bfm-share-tags')
    @include('bfm-share::meta_tags', [
        'url' => $video->detailsUrl,
        'title' => $video->title,
        'description' => str_limit(strip_tags($video->description), 300),
        'imageUrl' => $video->getImage('open_graph'),
        'imageSecureUrl' => BfmImage::init($video->image)->secure()->get('open_graph')
    ])
@endsection
