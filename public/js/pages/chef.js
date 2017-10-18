;(function($, window, document, undefined) {

    var Chef = {
        elements: {},
        cropText: function(){
            if($('.j-desc').height() <= 104){
                $('.j-desc').addClass('open');
            }else{
                $('.j-desc').addClass('more');
            }
        },
        initTabs: function(){
            $('.js-responsive-tabs').responsiveTabs({
                active: 0
            });
            $('.js-responsive-tabs .r-tabs-accordion-title .r-tabs-anchor').on('click', function(){
                var $link = $(this),
                    $target = $($link.attr('href'));

                Front.scrollTo($target, {
                    offset: - $link.outerHeight()
                });
            });
        },
        init: function(){
            var self = this;
            self.bindEvents();
            self.cropText();
            self.initTabs();
        },
        bindEvents:function () {
            var self = this;
            $(window).on('resize', function() {
                self.cropText();
            });
            $(document)
                .on('click', '.j-desc .j-more', function () {
                    $(this).closest('.j-desc').addClass('open');
                });
            }
        }

    Chef.init();

})(window.jQuery, window, document);