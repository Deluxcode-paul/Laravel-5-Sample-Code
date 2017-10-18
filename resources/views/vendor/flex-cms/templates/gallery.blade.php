<div class="cms-page__section is-media">
    <div class="site-width">
        <div class="heading-decorative">
            @unless(empty($model->heading))
            <h3 class="heading-decorative__title"><span>{{ $model->heading }}</span></h3>
            @endunless
            <h2 class="heading-decorative__subtitle">{{ $model->name }}</h2>
        </div>
        @include('partials.separator', ['type' => 'icon'])
        <div class="cms-page__content">
            <div class="cms-page__gallery swiper-container cms-gallery j-gallery-slider">
                <ul class="cms-gallery__list grid swiper-wrapper j-gallery">
                    @foreach($model->items()->get() as $item)
                        <li class="item-recipe swiper-slide">
                            <a href="{{ BfmImg::getImage($item, 'cms_gallery_items', 'image', 'max_w_1200') }}" class="item-recipe__wrapper">
                                <div class="item-recipe__visual">
                                    <img src="{{ BfmImg::getImage($item, 'cms_gallery_items', 'image', 'gallery', true) }}" class="item-recipe__img" alt="image" width="285" height="215" />
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if ($model->items()->get()->count() > 1)
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                @endif
            </div>
        </div>
    </div>
</div>