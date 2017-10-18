@extends('layouts.1column', [
    'page_class' => 'page-community'
])

@section('content')
    <div class="community-page">
        <div class="community-page__breadcrumb">
            <div class="site-width">
                {!! Breadcrumbs::render('community-question', $item) !!}
            </div>
        </div>
        <div class="site-width">
            <div class="community-page__wrapper">
                @include('community.community_question.blocks.header')
                <section class="community-page__content">
                    @include('community.blocks.items.item_details')
                    @include('community.blocks.reply_form', [
                        'replyFormRoute' => route('user.profile.activity.reply.community-question', $item->id)
                    ])
                </section>
            </div>
        </div>
    </div>
@endsection

@include('community.blocks.details_inline_script')