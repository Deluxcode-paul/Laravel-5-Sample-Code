@extends('layouts.1column', [
    'page_class' => 'page-community'
])

@section('content')
    <div class="community-page">
        <div class="community-page__breadcrumb">
            <div class="site-width">
                {!! Breadcrumbs::render('recipe-review', $item) !!}
            </div>
        </div>
        <div class="site-width">
            <div class="community-page__wrapper">
                @include('community.recipe_question.blocks.header')
                <section class="community-page__content">
                    @include('community.blocks.items.item_details')
                    @include('community.blocks.reply_form', [
                        'replyFormRoute' => route('user.profile.activity.reply.recipe-review', $item->id)
                    ])
                    @include('community.blocks.replies')
                </section>
            </div>
        </div>
    </div>
@endsection

@include('community.blocks.details_inline_script')