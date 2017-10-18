@extends('layouts.1column', ['cta' => 1])

@section('title', trans('errors.500.title'))

@section('content')
    <div class="category">
        <section class="section-heading" style="background-image: url('./images/bg-contact.jpg')">
            <div class="site-width">
                {!! Breadcrumbs::render('errors', [['title' => trans('errors.500.title'), 'url' => '']]) !!}
                <div class="page-heading__spacer">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title">
                            <span>@lang('errors.500.message')</span>
                        </h1>
                        <h2 class="heading-decorative__subtitle">
                            @lang('errors.500.title')
                        </h2>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
