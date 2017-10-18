var Watch = {
    selectors : {
        sortSelector: '.js-sort-selector',
        sortForm: '.js-sort-form'
    },
    init: function () {
        var self = this;
        self.bindEvents();
        self.initGallery();
        self.initSlider();
    },
    initSlider: function(){
        var self = this,
            $sliderrapper = $('.j-watch-slider');

        if ($sliderrapper.find('.swiper-slide').length > 1) {
            var loop = $sliderrapper.find('.swiper-slide').length > 4 ? true : false;
            var slider = new Swiper('.j-watch-slider .swiper-container', {
                nextButton: '.j-watch-slider .swiper-button-next',
                prevButton: '.j-watch-slider .swiper-button-prev',
                slidesPerView: 4,
                spaceBetween: 20,
                simulateTouch: false,
                loop: loop,
                breakpoints: {
                    980: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 2
                    },
                    480: {
                        slidesPerView: 1
                    }
                }
            });
        }
    },
    initGallery: function(){
        var self = this,
            $galleryWrapper = $('.j-watch-gallery');

        if ($galleryWrapper.find('.swiper-slide').length > 1) {
            var gallery = new Swiper('.j-watch-gallery .swiper-container', {
                nextButton: '.j-watch-gallery .swiper-button-next',
                prevButton: '.j-watch-gallery .swiper-button-prev',
                slidesPerView: 1,
                centeredSlides: true,
                pagination: '.swiper-pagination',
                paginationType: 'fraction',
                paginationFractionRender: function (swiper, currentClassName, totalClassName) {
                    return '<span class="' + currentClassName + '"></span>' + ' of ' + '<span class="' + totalClassName + '"></span>';
                }
            });
        }
    },
    bindEvents: function () {
        var self = this;
        $(self.selectors.sortSelector).change(function() {
            $(self.selectors.sortForm).submit();
        });
    }
};

$(document).ready(function () {
    Watch.init();
});