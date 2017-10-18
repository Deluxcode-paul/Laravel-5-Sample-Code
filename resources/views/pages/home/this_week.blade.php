<section class="this-week" style="background-image: url('{{ URL('/') }}/images/home/bg-thisweek1.jpg'), url('{{ URL('/') }}/images/home/bg-thisweek2.jpg');">
    <div class="site-width">
        <div class="heading-decorative">
            <h2 class="heading-decorative__title">
                <span>@lang('pages/home.headings.this')</span>
            </h2>
            <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.week')</h3>
        </div>
        @include('partials.separator', ['type' => 'icon'])
        <ul class="grid grid-row2_4">
            @foreach($mainThisWeekRecipes as $recipe)
                @include('pages.home.this_week.big_item')
            @endforeach
            @foreach($thisWeekRecipes as $recipe)
                @include('pages.home.this_week.small_item')
            @endforeach
        </ul>
    </div>
</section>