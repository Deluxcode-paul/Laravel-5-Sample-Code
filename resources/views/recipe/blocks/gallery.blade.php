@if ($gallery->count() > 0)
    <section class="section-gallery">
        <div class="swiper-container gallery-top">
            <ul class="swiper-wrapper">
                @foreach($gallery as $slide)
                    @include('recipe.blocks.gallery.slide')
                @endforeach
            </ul>
            @if ($gallery->count() > 1)
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
            @endif
        </div>
        @if ($gallery->count() > 1)
            <div class="gallery-thumbs">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
                        @foreach($gallery as $slide)
                            @include('recipe.blocks.gallery.thumbnail')
                        @endforeach
                    </ul>
                </div>
                <div class="swiper-button-next swiper-button-black"></div>
                <div class="swiper-button-prev swiper-button-black"></div>
            </div>
        @endif
    </section>
@endif