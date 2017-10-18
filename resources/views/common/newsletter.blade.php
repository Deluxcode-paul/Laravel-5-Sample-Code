<section class="section-newsletter" style="background-image: url('{{ URL('/') }}/images/bg-newsletter.jpg');">
    <div class="site-width">
        <div class="section-newsletter__spacer">
            <div class="section-newsletter__container">
                <div class="heading-decorative">
                    <h2 class="heading-decorative__title">
                        <span>@lang('common.newsletter.title0')</span>
                    </h2>
                    <h3 class="heading-decorative__subtitle">@lang('common.newsletter.title1')</h3>
                </div>
                <div class="descr">
                    @lang('common.newsletter.descr')
                </div>
                @include('bfm-newsletter::form')
            </div>
        </div>
    </div>
</section>