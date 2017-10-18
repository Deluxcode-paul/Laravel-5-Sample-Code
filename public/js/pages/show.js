var Show = {
    selectors : {
        sortSelector: '.js-sort-selector',
        sortForm: '.js-sort-form'
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        $(self.selectors.sortSelector).change(function() {
            $(self.selectors.sortForm).submit();
        });
    }
};

$(document).ready(function () {
    Show.init();
});