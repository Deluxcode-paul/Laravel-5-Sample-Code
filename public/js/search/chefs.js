var Chefs = {
    selectors : {
        clearFilterButton: '.js-clear-filters',
        sortSelector: '.js-sort-selector',
        filterForm: '.js-filter-form',
        sortForm: '.js-sort-form',

        stateContainer: '.js-state-container',
        countrySelect: '#country_id',
        stateSelect: '#state_id'
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
        $(self.selectors.countrySelect).change(function() {
            self.checkCountry();
        });
        self.checkCountry();
    },
    show: function(element) {
        $(element).removeClass('js-hidden');
    },
    hide: function(element) {
        $(element).addClass('js-hidden');
    },
    checkCountry: function() {
        var self = this;
        if ($(self.selectors.countrySelect).val() == Front.constants.USA_ID) {
            self.show(self.selectors.stateContainer);
        } else {
            self.hide(self.selectors.stateContainer);
            $(self.selectors.stateSelect).val('');
        }
    }
};

$(document).ready(function () {
    Chefs.init();
});