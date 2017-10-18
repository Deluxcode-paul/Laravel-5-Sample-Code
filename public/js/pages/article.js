var Article = {
    checkedAll: true,
    selectors : {
        printButton: '.js-print-article-button',
        emailButton: '.js-email-article-button'
    },
    constants: {
        printKeyCode: 80,
        hiddenClass: 'js-hidden'
    },
    init: function () {
        var self = this;
        self.bindEvents();
        self.initTabs();
    },
    initTabs: function(){
        $('.js-responsive-tabs').responsiveTabs({
            setHash: true,
            active: 0
        });
    },
    bindEvents: function () {
        var self = this;
        // Print
        $(document).off('click.print');
        $(document).on('click.print', self.selectors.printButton, function (e) {
            e.preventDefault();
            Print.print(Front.routes.print);
        });

        $(document).off('keydown.print');
        $(document).on('keydown.print', function(e){
            if ((e.ctrlKey && e.keyCode == self.constants.printKeyCode)
                && $(self.selectors.printButton).length > 0) {
                e.preventDefault();
                Print.print(Front.routes.print);
                return false;
            }
        });
        // Email
        $(self.selectors.emailButton).on('click', function(event) {
            event.preventDefault();
            EmailShare.showEmailPopup();
        });
    }
};

$(document).ready(function () {
    Article.init();
});