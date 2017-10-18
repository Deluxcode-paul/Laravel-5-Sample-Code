<section class="section-search">
    <div class="site-width">
        <div class="section-search__form">
            {{ Form::open([
                'url' => config('kosher.search_route'),
                'method' => 'GET',
                'class' => 'form'
                ]) }}
            <span class="sub">@lang('pages/home.labels.search_thousands')</span>
            {{ Form::hidden('reset', true) }}
            <div class="form-input">
                {{ Form::text(KosherHelper::getSearchKeywordParameter(), '', [
                    'placeholder' => trans('pages/home.placeholders.search'),
                    'class' => 'form-control'
                ]) }}
                <button type="submit" class="shearch-btn">
                    @include('partials.icons.icon-search')
                </button>
            </div>
            <span class="or">@lang('pages/home.labels.or')</span>
            <a class="btn is-large is-brown" href="{{ route('generate-a-meal') }}">@lang('pages/home.buttons.generate_meal')</a>
            {{ Form::close() }}
        </div>
    </div>
</section>
