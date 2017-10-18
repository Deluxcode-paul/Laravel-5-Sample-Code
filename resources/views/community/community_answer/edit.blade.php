@extends('layouts.1column', [
    'page_class' => 'page-ask'
])

@push('footer_js')
    <script src="{{ URL('/') }}/js/pages/contact.js"></script>
@endpush

@section('content')
    <div class="ask">
        <div class="ask__breadcrumb">
            <div class="site-width">
                {!! Breadcrumbs::render('community-question', $item->question) !!}
            </div>
        </div>
        <div class="site-width">
            <div class="ask__wrapper">
                <div class="actions">
                    <a class="link-arrow" href="{{ URL::previous() }}">@lang('community.buttons.go_back')</a>
                </div>
                <section class="ask__content">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title">
                            <span>@lang('community.headings.edit')</span>
                        </h1>
                        <h2 class="heading-decorative__subtitle">@lang('community.headings.post')</h2>
                    </div>
                    @include('community.blocks.edit_reply_form', [
                        'formAction' => $item->updateUrl
                    ])
                    @include('community.blocks.delete_form', [
                        'deleteFormAction' => $item->deleteUrl
                    ])
                </section>
            </div>
        </div>
    </div>
@endsection

@include('community.blocks.edit_inline_script')