<section class="community"  style="background-image: url('{{ URL('/') }}/images/home/bg-community1.jpg'), url('{{ URL('/') }}/images/home/bg-community2.jpg');">
    <div class="site-width">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('pages/home.headings.our')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.community')</h3>
        </div>
        @include('partials.separator', ['type' => 'icon'])
        <ul class="community__list">
            @foreach ($community as $item)
                @include('community.blocks.items.item')
            @endforeach
        </ul>
        <div class="a-center actions">
            <a class="btn is-purple" href="{{ route('community') }}">@lang('pages/home.buttons.community')</a>
        </div>
    </div>
</section>