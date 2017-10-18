$(document).ready(function() {
    $('body').find('input.date-picker').not('.hide input.date-picker').each(function () {
        var _this = $(this);

        if (_this.hasClass('is-initialized')) return;

        var datepickerOptions = {
            field: _this[0],
            format: 'MM/DD/YYYY'
        };

        if (_this.data('min-date')) {
            datepickerOptions.minDate = new Date(_this.data('min-date'));
        }

        if (_this.data('max-date')) {
            datepickerOptions.maxDate= new Date(_this.data('max-date'));
        }

        new Pikaday(datepickerOptions);

        _this.addClass('is-initialized');
    });
});