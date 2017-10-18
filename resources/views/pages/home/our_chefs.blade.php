<section class="our-chef j-ourchef" style="background-image: url('{{ URL('/') }}/images/home/bg-ourchef.jpg');">
    <div class="site-width">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($chefs as $chef)
                    <div class="swiper-slide our-chef__item">
                        <div class="our-chef__img" style="background-image: url('{{ $chef->getImage('user_home_page_slider_big') }}');"></div>
                        <div class="our-chef__desc">
                            <div class="content">
                                <div class="heading-decorative">
                                    <h2 class="heading-decorative__title">
                                        <span>@lang('pages/home.headings.our')</span>
                                    </h2>
                                    <h3 class="heading-decorative__subtitle">@lang('pages/home.headings.chefs')</h3>
                                </div>
                                <h3 class="name">{{ $chef->fullName }}</h3>
                                <div class="info">
                                    @if ($chef->location)
                                        <span>{{ $chef->location }}</span>
                                    @endif
                                    @if ($chef->place_of_work)
                                        @if ($chef->location)
                                            <span> / </span>
                                        @endif
                                        <span>{{ $chef->place_of_work }}</span>
                                    @endif
                                </div>

                                @if ($chef->bio)
                                    <div class="bio">{!! nl2br(e($chef->bio)) !!}</div>
                                @endif

                                @if ($chef->status)
                                    <div class="quote">"{{ $chef->status }}"</div>
                                @endif

                                <a class="link-gold" href="{{ $chef->publicProfileUrl }}">@lang('pages/home.buttons.view_full_bio')</a>
                                <br>
                                {{-- TODO: Add anchor to recipes page part --}}
                                <a class="btn is-purple" href="{{ $chef->publicProfileUrl }}">@lang('pages/home.buttons.view_recipes_by_chef')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="our-chef__navigation">
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
        <div class="swiper-pagination our-chef__pagination">
            <ul>
                @foreach($chefs as $index=>$chef)
                    <li data-index="{{ $index }}">
                        <img src="{{ $chef->getImage('user_home_page_slider_small') }}" />
                    </li>
                @endforeach
                <li>
                    <a href="{{ route('about.chefs') }}" class="link-gold">@lang('pages/home.buttons.view_all_chefs')</a>
                </li>
            </ul>
        </div>
    </div>
</section>

