;(function($, window, document, undefined) {

    var Home = {
        elements: {},
        initBanner: function(){
            var self = this,
                $bannerWrapper = $('.j-banner');

            self.elements.$bannerWrapper = $bannerWrapper;

            if ($bannerWrapper.find('.swiper-slide').length > 1) {
                self.bannerSwiper = new Swiper('.j-banner .swiper-container', {
                    nextButton: '.j-banner .swiper-button-next-wrap',
                    prevButton: '.j-banner .swiper-button-prev-wrap',
                    slidesPerView: 'auto',
                    centeredSlides: true,
                    loop: true,
                    roundLengths: true
                });
            }
        },
        initOurChefSlider: function(){
            var self = this,
                $chefWrapper = $('.j-ourchef');

            self.elements.$chefWrapper = $chefWrapper;

            $chefWrapper.find('.our-chef__pagination li:first-child').addClass('active');

            if ($chefWrapper.find('.swiper-slide').length > 1) {
                self.chefSlider = new Swiper('.j-ourchef .swiper-container', {
                    nextButton: '.j-ourchef .swiper-button-next',
                    prevButton: '.j-ourchef .swiper-button-prev',
                    slidesPerView: 1,
                    centeredSlides: true,
                    calculateHeight:true,
                    onSlideChangeStart: function (swiper) {
                        $('.j-ourchef .our-chef__pagination li').removeClass('active');
                        $('.j-ourchef .our-chef__pagination li[data-index="'+self.chefSlider.activeIndex+'"]').addClass('active');
                    }
                });
            }else{
                $('.j-ourchef .swiper-button-next, .j-ourchef .swiper-button-prev').hide();
                $('.j-ourchef .swiper-slide').addClass('swiper-slide-active');
            }
        },
        init: function(){
            var self = this;
            self.bindEvents();
            self.initBanner();
            self.initOurChefSlider();
        },
        bindEvents:function () {
        var self = this;
        $(document)
            .on('click', '.j-ourchef .our-chef__pagination li', function () {
                var $item = $(this);
                $('.j-ourchef .our-chef__pagination li').removeClass('active');
                $item.addClass('active');
                self.chefSlider.slideTo($item.data('index'));
            });
        }
    }

    Home.init();

})(window.jQuery, window, document);