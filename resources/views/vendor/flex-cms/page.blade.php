@extends('layouts.1column', [
    'page_class' => 'page-cms'
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/cms.js"></script>
@endpush

@section('title', $page->title)

@section('content')
    <div class="cms-page">
        <section class="page-heading" style="background-image: url('{{ empty($page->image) ? url('images/bg-cms.jpg') : BfmImage::init($page->image)->blur(60)->get('home_banner_alone') }}');">
            <div class="site-width">
                {!! Breadcrumbs::render('cms', empty($breadcrumbs) ? [['title' => $page->title, 'url' => $page->url]] : $breadcrumbs) !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        @unless(empty($page->headline))
                        <h1 class="heading-decorative__title"><span>{{ $page->headline }}</span></h1>
                        @endunless
                        <h2 class="heading-decorative__subtitle">{{ $page->title }}</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class="cms-page__wrapper j-cms-page">
            {!! $page->content !!}
        </section>
    </div>
@endsection