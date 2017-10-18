;(function($, window, document, undefined) {

    var RecipeDetails = {
        elements: {},
        cropText: function(){
            var $descr = $('.j-overview-descr'),
                $wrapper = $descr.closest('.j-overview'),
                $aside = $wrapper.find('.j-overview-aside'),
                LINE_HEIGH = 26,
                MIN_HEIGHT = 26 * 5,
                height = $aside.height() > MIN_HEIGHT && ($(window).width() >= 768) ? $aside.height() : MIN_HEIGHT;

            if($descr.height() <= height){
                $descr.addClass('open');
            }else{
                $descr.addClass('more');
                $descr.css('maxHeight', height);
            }

            $(document).on('click', '.j-more', function () {
                $(this).closest($descr).addClass('open');
            });
        },
        initTabs: function(){
            $('.js-responsive-tabs').responsiveTabs({
                setHash: true,
                active: 0
            });
        },
        initGallery: function(){
            var self = this,
                $galleryWrapper = $('.section-gallery');

            self.elements.$galleryWrapper = $galleryWrapper;

            if ($galleryWrapper.find('.gallery-top .swiper-slide').length > 1) {
                var gallery = new Swiper('.gallery-top', {
                    nextButton: '.gallery-top .swiper-button-next',
                    prevButton: '.gallery-top .swiper-button-prev',
                    spaceBetween: 12,
                    lazyLoading: true,
                    lazyLoadingInPrevNext: true,
                    lazyLoadingOnTransitionStart: true
                });
            }

            if ($galleryWrapper.find('.gallery-thumbs .swiper-slide').length > 1) {
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
                $('.gallery-thumbs .swiper-container').on('click', function(e){
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
        },
        initImagesSwitch: function(){
            var self = this,
                $switcher = $('[name="switch-images"]'),
                $steps = $('.js-steps'),
                $imgs = $steps.find('img[data-src]'),
                $body = $('body'),
                imgsLoaded = false;

            if (!$imgs.length) return;

            $imgs.hide();

            $switcher.on('change', function(){

                if (imgsLoaded) {
                    $imgs.toggle($(this).val() == 'on');
                    return;
                }

                $body.addClass('is-loading');

                $imgs.each(function(i){
                    var $img = $(this),
                        newImage = new Image();
                    newImage.onload = function(){
                        $img.attr('src', newImage.src);
                        imgsLoaded = true;
                        if ((i + 1) == $imgs.length) {
                            $imgs.show();
                            $body.removeClass('is-loading');
                        }
                    }
                    newImage.src = $img.data('src');
                });

            });
        },
        initIngredients: function(){
            var $wrapper = $('.section-ingredients'),
                $ingredients = $wrapper.find('.js-ingredient-ckb');

            $wrapper.find('.js-select-all').on('click', function(e){
                e.preventDefault();

                var _this = $(this);

                if (!_this.hasClass('is-active')) {
                    $ingredients.each(function(){
                        $(this)[0].checked = true;
                    });
                    _this.addClass('is-active');
                } else {
                    $ingredients.each(function(){
                        $(this)[0].checked = false;
                    });
                    _this.removeClass('is-active');
                }
            });
            $wrapper.find('.js-add-to-shopping-list').on('click', function(e){
                e.preventDefault();
                var _this = $(this),
                    data = [];
                $ingredients.each(function(){
                    if ($(this).is(":checked")){
                        data.push($(this).val());
                    }
                });
                $.ajax({
                    url: '/user/shopping-list/add',
                    type: 'POST',
                    data: {
                        'ingredients': data,
                        'recipe': _this.data('recipe-id')
                    },
                    error: function(){
                        Front.showMessage(_this.data('error'), 'error');
                    },
                    success: function(res){
                        Front.showMessage(res.message, 'success');
                    }
                });
            });
            $(document).find('.js-add-to-recipe-box').on('click', function(e){
                e.preventDefault();
                var _this = $(this),
                    data = [];
                $ingredients.each(function(){
                    data.push($(this).val());
                });
                $.ajax({
                    url: '/user/recipe-box/add',
                    type: 'POST',
                    data: {
                        'recipe': _this.data('recipe-id')
                    },
                    error: function () {
                        Front.showMessage(_this.data('error'), 'error');
                    },
                    success: function (res) {
                        switch (res.status) {
                            case 'ok':
                                $('.js-save-recipe-wrapper').html(res.button);
                                $('.js-save-recipe-ingredients-wrapper').html(res.ingredients);
                                Front.showMessage(res.message, 'success');
                                break;
                            case 'auth':
                                window.location.href = res.redirect;
                                break;
                            case 'error':
                                Front.showMessage(res.message, 'error');
                                break;
                            default:
                                Front.showMessage(res.message);
                                break;
                        }
                    }
                })
            })
        },
        rating: function(){
            $(document).on('change', '.j-rating-radio input[type="radio"]', function(){
                $('.j-rating-radio').attr('data-rating', $(this).val());
            });
        },
        init: function(){
            var self = this;
            self.initGallery();
            self.initImagesSwitch();
            self.initIngredients();
            self.initTabs();
            self.rating();
            self.cropText();
        }
    }

    RecipeDetails.init();

})(window.jQuery, window, document);