@extends('layouts.1column', [
    'page_class' => 'page-contact'
])

@section('title', trans('titles.contact'))

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/contact.js"></script>
@endpush

@section('content')
    <div class="contact">
        <section class="page-heading" style="background-image: url('{{ URL('/') }}/images/bg-contact.jpg');">
            <div class="site-width">
                {!! Breadcrumbs::render('contact') !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title"><span>@lang('pages/contact.headings.welcome')</span></h1>
                        <h2 class="heading-decorative__subtitle">@lang('pages/contact.headings.how_may_we_help')</h2>
                    </div>
                    <div class="contact__navigation">
                        <div class="item">
                            <a href="{{ url(config('kosher.links.faq')) }}" class="contact__link is-faq">
                                @include('partials.icons.icon-faq')
                                <span>
                                    @lang('pages/contact.labels.check_out') <br>
                                    @lang('pages/contact.labels.our')
                                    <i>@lang('pages/contact.labels.faq')</i>
                                </span>
                            </a>
                        </div>
                        <div class="item">
                            <a href="{{ route('community') }}" class="contact__link is-forum">
                                @include('partials.icons.icon-forum')
                                <span>
                                    @lang('pages/contact.labels.view_our')
                                    <br><i>@lang('pages/contact.labels.discussion_forum')</i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="site-width">
            <div class="contact__wrapper">
                <div class="contact__form">
                    @include('pages.contact.form')
                </div>
            </div>
        </div>
    </div>
@endsection