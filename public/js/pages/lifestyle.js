;(function($, window, document, undefined) {

    var Lifestyle = {
        init: function () {
            var self = this;
            self.initSlider();
        },
        initSlider: function(){
            var self = this,
                $sliderWrapper = $('.j-lifestyle-slider');

            if ($sliderWrapper.find('.swiper-slide').length > 1) {
                var slider = new Swiper('.j-lifestyle-slider .swiper-container', {
                    nextButton: '.j-lifestyle-slider .swiper-button-next',
                    prevButton: '.j-lifestyle-slider .swiper-button-prev',
                    slidesPerView: 1
                });
            }
        }
    };

    Lifestyle.init();

})(window.jQuery, window, document);