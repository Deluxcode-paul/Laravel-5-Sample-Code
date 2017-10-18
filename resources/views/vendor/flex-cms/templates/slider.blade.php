<div class="cms-page__section is-media">
    <div class="site-width">
        <div class="heading-decorative">
            @unless (empty($model->heading))
            <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
            @endunless
            <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
        </div>
        <div class="cms-page__content">
            <div class="cms-page__slider">
                <section class="section-gallery">
                    <div class="swiper-container gallery-top">
                        <ul class="swiper-wrapper">
                            @foreach($model->items()->get() as $item)
                                <li class="swiper-slide">
                                    @if ($model->items()->get()->count() == 1)
                                        <div class="gallery-top__img" style="background-image: url('{{ BfmImg::getImage($item, 'cms_slider_items', 'image', 'slide', true) }}');"></div>
                                    @else
                                        <div class="gallery-top__img swiper-lazy" data-background="{{ BfmImg::getImage($item, 'cms_slider_items', 'image', 'slide', true) }}"></div>
                                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @if ($model->items()->get()->count() > 1)
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        @endif
                    </div>
                    @if ($model->items()->get()->count() > 1)
                        <div class="gallery-thumbs">
                            <div class="swiper-container">
                                <ul class="swiper-wrapper">
                                    @foreach($model->items()->get() as $item)
                                        <li class="swiper-slide">
                                            <img src="{{ BfmImg::getImage($item, 'cms_slider_items', 'image', 'slide_thumbnail', true) }}"  alt="{{ $item->title }}" />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="swiper-button-next swiper-button-black"></div>
                            <div class="swiper-button-prev swiper-button-black"></div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</div>



