;(function($, window, document, undefined) {

    var CMS = {
        elements: {},
        init: function(){
            var self = this;
            self.bindEvents();
            self.wrapTable();
            self.initTabs();
            self.initGallery($('.j-gallery-slider'));
            self.initSlider();
        },
        wrapTable: function(){
            var $table = $('.j-cms-page table');
            if($table.length){
                $table.wrap('<div class="cms-page__table"></div>');
            }
        },
        initTabs: function(){
            $('.js-responsive-tabs').responsiveTabs({
                active: 0
            });
        },
        initGallery: function($wrap){
            var $el = $wrap.find('.j-gallery'),
                slider;

            $el.each(function(){
                var $gallery = $(this);
                $gallery.magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
                        tPrev: 'Previous (Left arrow key)',
                        tNext: 'Next (Right arrow key)'
                    }
                });
            });

            if ($wrap.find('.swiper-slide').length > 1) {
                enquire.register("screen and (max-width:600px)", {
                    match : function() {
                        slider = new Swiper($wrap, {
                            nextButton: $wrap.find('.swiper-button-next'),
                            prevButton: $wrap.find('.swiper-button-prev'),
                            slidesPerView: 'auto',
                            centeredSlides: true
                        });
                    }
                });
                enquire.register("screen and (min-width:601px)", {
                    match : function() {
                        if (slider instanceof Swiper) {
                            slider.destroy(true, true);
                            slider = null;
                        }
                    }
                });
            }
        },
        initSlider: function(){
            var self = this,
                $galleryWrapper = $('.section-gallery');

            $galleryWrapper.each(function(){
                var $wrap = $(this),
                    gallery,
                    galleryNav;

                if ($wrap.find('.gallery-top .swiper-slide').length > 1) {
                    gallery = new Swiper($wrap.find('.gallery-top'), {
                        nextButton: $wrap.find('.gallery-top .swiper-button-next'),
                        prevButton: $wrap.find('.gallery-top .swiper-button-prev'),
                        spaceBetween: 12,
                        lazyLoading: true,
                        lazyLoadingInPrevNext: true,
                        lazyLoadingOnTransitionStart: true
                    });
                }


                var galleryNav = new Swiper('.gallery-thumbs .swiper-container', {
                    nextButton: '.gallery-thumbs .swiper-button-next',
                    prevButton: '.gallery-thumbs .swiper-button-prev',
                    spaceBetween: 12,
                    slidesPerView: 6,
                    touchRatio: 0.2,
                    preventClicks: false,
                    observer: true,
                    breakpoints: {
                        600: {
                            spaceBetween: 5,
                            slidesPerView: 'auto',
                            centeredSlides: true,
                            initialSlide: 1
                        }
                    },
                    onInit: function(swiper){
                        $(swiper.slides[gallery.activeIndex]).addClass('is-current');
                    }
                });


                if ($wrap.find('.gallery-thumbs .swiper-slide').length > 1) {
                    galleryNav = new Swiper($wrap.find('.gallery-thumbs .swiper-container'), {
                        nextButton: $wrap.find('.gallery-thumbs .swiper-button-next'),
                        prevButton: $wrap.find('.gallery-thumbs .swiper-button-prev'),
                        spaceBetween: 12,
                        slidesPerView: 6,
                        touchRatio: 0.2,
                        preventClicks: false,
                        observer: true,
                        breakpoints: {
                            600: {
                                spaceBetween: 5,
                                slidesPerView: 'auto',
                                centeredSlides: true,
                                initialSlide: 1
                            }
                        },
                        onInit: function(swiper){
                            $(swiper.slides[gallery.activeIndex]).addClass('is-current');
                        }
                    });
                    enquire.register('screen and (max-width:600px)', function(){
                        galleryNav.params.centeredSlides = true;
                    });
                    enquire.register('screen and (min-width:601px)', function(){
                        galleryNav.params.centeredSlides = false;
                    });
                }

                if (gallery && galleryNav) {
                    gallery.on('slideChangeStart', function(swiper){
                        $(galleryNav.slides[swiper.previousIndex]).removeClass('is-current');
                        $(galleryNav.slides[swiper.activeIndex]).addClass('is-current');
                        galleryNav.slideTo(swiper.activeIndex);
                    });
                    $wrap.find('.gallery-thumbs .swiper-container').on('click', function(e){
                        var $target = $(e.target);
                        if (!$target.hasClass('swiper-slide')) return;
                        if ($target.hasClass('is-current')) return;
                        e.preventDefault();
                        gallery.slideTo($target.index());
                        galleryNav.slideTo($target.index());
                        $target.siblings('.swiper-slide').removeClass('is-current');
                        $target.addClass('is-current');
                    });
                }
            });
        },
        switchFaq: function($link){
            var $item = $link.closest('.j-faq-accordion');

            $item.toggleClass('open');
        },
        bindEvents: function () {
            var self = this;
            $(document)
                .on('click', '.j-faq-accordion-opener', function (e) {
                    e.preventDefault();
                    self.switchFaq($(this));
                });
        }
    }

    CMS.init();

})(window.jQuery, window, document);