;(function($, window, document, undefined) {

    var Auth = {
        elements: {},
        initTabs: function(tabs){
            tabs.responsiveTabs({
                setHash: true,
                active: 0
            });
        },
        initForms: function(forms){
            forms.each(function(){
                $(this).parsley();
            });
        },
        init: function(){
            var self = this;
            self.elements.$wrapper = $('#js-page-auth');
            self.elements.$tabs = self.elements.$wrapper.find('.js-responsive-tabs');
            self.elements.$forms = self.elements.$wrapper.find('.js-form');

            self.initTabs(self.elements.$tabs);
            self.initForms(self.elements.$forms);
        }
    }

    Auth.init();

})(window.jQuery, window, document);