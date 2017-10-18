window.Front = {
    routes: {},
    translations: {},
    elements: {},
    constants : {
        USA_ID: 1
    },
    showMessage(message, type){
        type = type ? type : '';
        type = type.toLowerCase();
        alertify.notify(message, type);
    },
    scrollTo($target, options){

        var $target = $($target),
            distance;

        var options = $.extend({
            offset: 0,
            duration: 500,
            forced: true,
            speed: null,
            onAfter: null
        }, options || {});

        var scrollPoint = $target.offset().top + options.offset,
            windowTop = $(window).scrollTop();

        if (!options.forced && windowTop <= scrollPoint) return;

        if (this.elements.$header.hasClass('is-fixed')) scrollPoint -= this.elements.$header.height();

        if (scrollPoint < 100) scrollPoint = 0;

        // distance = Math.abs(scrollPoint - windowTop);

        $('html,body').animate({
            scrollTop: scrollPoint,
        }, {
            duration: options.duration,
            complete: options.onAfter
        });
    },
    confirm(confirmationMessage) {return confirm(confirmationMessage)},
    initMegamenu(){
        let $body = this.elements.$body,
            $opener = $body.find('.main-nav__menu li.has-sub a.ajax'),
            $windowWidth = $(window).width(),
            $megamenu = $body.find('#js-megamenu'),
            $url;

        if (!$opener.length) return;

        $url = $opener.data('ajaxUrl');

        if (!$url) return;

        $megamenu[0].addEventListener('outclick', function(e){
            if ($megamenu.hasClass('is-open')) {
                $megamenu.attr('class');
                $megamenu.removeClass('is-open');
                $body.removeClass('with-overlay');
                $opener.removeClass('is-active');
                $body.off('.megamenu');
            }
        }, [$opener[0]]);

        $opener.on('click', function(e){
            e.preventDefault();

            if ($opener.hasClass('is-active')) {
                $opener.removeClass('is-active');
                $megamenu.removeClass('is-open');
                $body.removeClass('with-overlay');
                $body.off('.megamenu');
                return;
            }

            if ($opener.hasClass('is-loaded')) {
                $opener.addClass('is-active');
                $megamenu.addClass('is-open');
                $body.addClass('with-overlay');
                return;
            }

            $body.addClass('is-loading with-black-overlay');

            $.ajax({
                url: $url,
                complete() {$body.removeClass('is-loading with-black-overlay');},
                success(res) {

                    $opener.addClass('is-loaded is-active');

                    $megamenu.html(res.content);
                    $megamenu.addClass('is-open');

                    $body.addClass('with-overlay');

                }
            });
        });
    },
    initCTA(){
        let $ctaContent = $('#js-section-cta'),
            $body = this.elements.$body;

        if (!$ctaContent.length) return;

        $.ajax({
            url: '/ajax/call-to-actions',
            complete() {},
            success(res) {$ctaContent.html(res.content);}
        });
    },
    initFixedHeader(){
        let $body = this.elements.$body,
            $header = $body.find('.site-header'),
            $window = $(window),
            triggerPoint = $header.position().top + $header.height();

        $header.toggleClass('is-fixed', $window.scrollTop() > triggerPoint);

        $window.on('scroll resize orientationchange', throttle(100, () => {
            $header.toggleClass('is-fixed', $window.scrollTop() > triggerPoint);
        }));
    },
    initMobileNavigation(){
        let $body = this.elements.$body,
            $openHeaderNavSelector = $body.find('.j-open-nav'),
            $headerNav = $openHeaderNavSelector.closest('.j-nav');

        $openHeaderNavSelector.on('click', function () {
            $headerNav.toggleClass('open');
        });
    },
    initMobileFooterNavigation(){
        let $body = this.elements.$body,
            $openFooterNavSelector = $body.find('.j-open-footerNav'),
            $footerNav = $openFooterNavSelector.closest('.j-footerNav');

        $openFooterNavSelector.on('click', function () {
            $footerNav.toggleClass('open');
        });
    },
    initMobileSubnav(){
        let $subnav = $('#js-site-header .j-subnav, #js-site-header .j-subnav > span');

        enquire.register("screen and (max-width:1200px)", function(){
            $subnav.on('click.sub-nav', function (e) {
                $(this).toggleClass('is-active');
            });
        });
        enquire.register("screen and (min-width:1201px)", function(){
            $subnav.off('click.sub-nav', function (e) {
                $(this).toggleClass('is-active');
            });
        });
    },
    init(){
        let self = this;

        self.isTouch = 'ontouchstart' in window ||
            window.DocumentTouch && document instanceof window.DocumentTouch ||
            navigator.maxTouchPoints > 0 ||
            window.navigator.msMaxTouchPoints > 0;

        self.elements.$html = $('html');
        self.elements.$body = $('body');
        self.elements.$header = $('.site-header');

        self.elements.$html.addClass(self.isTouch ? 'touchevents' : 'no-touchevents');

        self.initMegamenu();
        self.initFixedHeader();
        self.initCTA();
        self.initMobileNavigation();
        self.initMobileFooterNavigation();
        self.initMobileSubnav();

        String.prototype.hasExtension = function(exts){
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(this);
        };

    }
};

jQuery(document).ready(($) => {
    Front.init();
});