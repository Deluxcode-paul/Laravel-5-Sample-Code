@extends('layouts.1column', ['page_class' => 'maintenance'])

@section('title', trans('pages/maintenance.heading'))

@section('content')
    <div class="category">
        <section class="section-heading" style="background-image: url('./images/bg-category.jpg')">
            <div class="site-width">
                {!! Breadcrumbs::render('maintenance') !!}
                <div class="heading-decorative">
                    <h1 class="heading-decorative__title">
                        <span>@lang('pages/maintenance.heading')</span>
                    </h1>
                    <h2 class="heading-decorative__subtitle">
                        @lang('pages/maintenance.message')
                    </h2>
                </div>
            </div>
        </section>
    </div>
@endsection
