@extends('layouts.1column', [
    'page_class' => 'page-chef'
])

@section('title', trans('titles.about_chefs'))

@section('content')
    <div class="chefs">
        <section class="page-heading" style="background-image: url('{{ URL('/') }}/images/bg-chefs.jpg');">
            <div class="site-width">
                {!! Breadcrumbs::render('about.chefs') !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title"><span>@lang('pages/chefs.headings.about')</span></h1>
                        <h2 class="heading-decorative__subtitle">@lang('pages/chefs.headings.chefs')</h2>
                    </div>
                </div>
            </div>
        </section>
        <div class="chefs__wrapper">
            <div class="site-width">
                <ul class="chefs__list">
                    @foreach ($chefs as $chef)
                        <li>
                            <a href="{{ $chef->publicProfileUrl }}">
                                <img class="img-circle" src="{{ $chef->getImage('user_chefs_page') }}" />
                                <span>{{ $chef->fullName }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="chefs__content">
                    <h3 class="title">@lang('pages/chefs.content.title')</h3>
                    <div class="desc">
                        @lang('pages/chefs.content.text')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



