var Watch = {
    selectors : {
        clearFilterButton: '.js-clear-filters',
        sortSelector: '.js-sort-selector',
        filterForm: '.js-filter-form',
        sortForm: '.js-sort-form'
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        $(self.selectors.clearFilterButton).on('click', function(event) {
            event.preventDefault();
            $(self.selectors.filterForm + ' select').val('');
            $(self.selectors.filterForm).submit();
        });
        $(self.selectors.sortSelector).change(function() {
            $(self.selectors.sortForm).submit();
        });
    }
};

$(document).ready(function () {
    Watch.init();
});