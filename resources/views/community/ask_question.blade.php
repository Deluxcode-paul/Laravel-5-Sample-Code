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
                {!! Breadcrumbs::render('community.ask-question') !!}
            </div>
        </div>
        <div class="site-width">
            <div class="ask__wrapper">
                <div class="actions">
                    <a class="link-arrow" href="{{ route('community') }}">@lang('community.buttons.go_back')</a>
                </div>
                <section class="ask__content">
                    <div class="heading-decorative">
                        <h1 class="heading-decorative__title">
                            <span>@lang('community.headings.ask')</span>
                        </h1>
                        <h2 class="heading-decorative__subtitle">@lang('community.headings.question')</h2>
                    </div>
                    {{ Form::open([
                        'url' => route('community.ask-question.save'),
                        'method' => 'POST',
                        'class' => 'form-grey form-ask j-ask-form'
                    ]) }}
                    <div class="form-row{{ $errors->has('title') ? ' has-error' : '' }}">
                        <div class="form-item">
                            {{ Form::label('title', trans('community.labels.title'), [
                                'class' => 'form-label'
                            ]) }}

                            <div class="form-input">
                                {{ Form::text('title', '', [
                                    'placeholder' => trans('community.placeholders.title'),
                                     'maxlength' => 255,
                                     'required',
                                     'class' => 'form-control',
                                 ]) }}

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-row{{ $errors->has('details') ? ' has-error' : '' }}">
                        <div class="form-item">
                            {{ Form::label('details', trans('community.labels.details'), [
                                'class' => 'form-label'
                            ]) }}

                            <div class="form-input">
                                {{ Form::textarea('details', '', [
                                    'placeholder' => trans('community.placeholders.details'),
                                     'required',
                                     'class' => 'form-control',
                                 ]) }}

                                @if ($errors->has('details'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('details') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-item">
                            <label for="tags" class="form-label">
                                @lang('community.labels.tags')
                                <span>@lang('community.helpers.tags')</span>
                            </label>
                            <div class="form-input">
                                {{ Form::select('tags[]', $tags, '', [
                                    's2_placeholder' => trans('community.placeholders.tags'),
                                    'maximumSelectionLength' => config('kosher.max_tags_ask_question'),
                                    'multiple' => 'multiple',
                                    'required',
                                    'class' => 'js-select2'
                                ]) }}

                                @if ($errors->has('tags'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tags') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-item">
                            <label for="chefs" class="form-label">
                                @lang('community.labels.chefs')
                                <i>@lang('community.helpers.chefs')</i>
                            </label>
                            <div class="form-input">
                                {{ Form::select('chefs[]', $chefs, '', [
                                    's2_placeholder' => trans('community.placeholders.chefs'),
                                    'maximumSelectionLength' => config('kosher.max_chefs_ask_question'),
                                    'multiple' => 'multiple',
                                    'class' => 'js-select2'
                                ]) }}

                                @if ($errors->has('chefs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('chefs') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn is-purple is-large">
                            @lang('community.buttons.post_question')
                        </button>
                    </div>
                    {{ Form::close() }}
                </section>
            </div>
        </div>
    </div>
@endsection
