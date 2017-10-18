<section class="banner j-banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @if ($bannerItems->count() > 1)
                @foreach($bannerItems as $item)
                <a href="{{ $item->getBannerUrl() }}" class="swiper-slide banner__item" style="background-image: url('{{ $item->getBannerPicture() }}');">
                    <div class="site-width">
                        <div class="banner__desc">
                            <div class="heading-decorative">
                                <h2 class="heading-decorative__title">
                                    <span>{{ $item->getBannerHeading() }}</span>
                                </h2>
                                <h3 class="heading-decorative__subtitle">{{ $item->getBannerSubheading() }}</h3>
                            </div>
                            @include('partials.separator', ['type' => 'icon'])
                            <div class="content">
                                @if ($item->getBannerCategory())
                                    <span class="category">{{ $item->getBannerCategory() }}</span>
                                @endif
                                <h3 class="title">{{ $item->getBannerTitle() }}</h3>
                                <p class="desc">{!! strip_tags($item->getBannerDescription()) !!}</p>
                                <span class="link-gold">{{ $item->getBannerButton() }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <a href="{{ $bannerItems->first()->getBannerUrl() }}" class="swiper-slide banner__item swiper-slide banner__item-alone swiper-slide-active" style="background-image: url('{{ $bannerItems->first()->getBannerPicture('home_banner_alone') }}');">
                    <div class="site-width">
                        <div class="banner__desc">
                            <div class="heading-decorative">
                                <h2 class="heading-decorative__title">
                                    <span>{{ $bannerItems->first()->getBannerHeading() }}</span>
                                </h2>
                                <h3 class="heading-decorative__subtitle">{{ $bannerItems->first()->getBannerSubheading() }}</h3>
                            </div>
                            @include('partials.separator', ['type' => 'icon'])
                            <div class="content">
                                @if ($bannerItems->first()->getBannerCategory())
                                    <span class="category">{{ $bannerItems->first()->getBannerCategory() }}</span>
                                @endif
                                <h3 class="title">{{ $bannerItems->first()->getBannerTitle() }}</h3>
                                <p class="desc">{!! strip_tags($bannerItems->first()->getBannerDescription()) !!}</p>
                                <span class="link-gold">{{ $bannerItems->first()->getBannerButton() }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
        </div>
        @if ($bannerItems->count() > 1)
            <div class="banner__navigation">
                <div class="swiper-button-next-wrap"><div class="swiper-button-next swiper-button-white"><span></span></div></div>
                <div class="swiper-button-prev-wrap"><div class="swiper-button-prev swiper-button-white"><span></span></div></div>
            </div>
        @endif
    </div>
</section>
