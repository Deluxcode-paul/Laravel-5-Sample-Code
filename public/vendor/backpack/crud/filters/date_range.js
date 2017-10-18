$(document).ready(function() {
    var startDate = {},
        endDate = {},
        startPicker = {},
        endPicker = {},
        $body = $('body');

    var updateStartDate = function(name) {
        startPicker[name].setStartRange(startDate[name]);
        endPicker[name].setStartRange(startDate[name]);
        endPicker[name].setMinDate(startDate[name]);
    };

    var updateEndDate = function(name) {
        startPicker[name].setEndRange(endDate[name]);
        startPicker[name].setMaxDate(endDate[name]);
        endPicker[name].setEndRange(endDate[name]);
    };

    $body.find('input.date-picker-start').not('.hide input.date-picker-start').each(function () {
        var _this = $(this);

        if (_this.hasClass('is-initialized')) return;

        var name = _this.data('name');
        var datepickerOptions = {
            field: _this[0],
            format: 'MM/DD/YYYY',
            onSelect: function() {
                startDate[name] = this.getDate();
                updateStartDate(name);
            }
        };

        if (_this.data('min-date')) {
            datepickerOptions.minDate = new Date(_this.data('min-date'));
        }

        if (_this.data('max-date')) {
            datepickerOptions.maxDate= new Date(_this.data('max-date'));
        }

        startPicker[name] = new Pikaday(datepickerOptions);

        _this.addClass('is-initialized');
    });

    $body.find('input.date-picker-end').not('.hide input.date-picker-end').each(function () {
        var _this = $(this);

        if (_this.hasClass('is-initialized')) return;

        var name = _this.data('name');
        var datepickerOptions = {
            field: _this[0],
            format: 'MM/DD/YYYY',
            onSelect: function() {
                endDate[name] = this.getDate();
                updateEndDate(name);
            }
        };

        if (_this.data('min-date')) {
            datepickerOptions.minDate = new Date(_this.data('min-date'));
        }

        if (_this.data('max-date')) {
            datepickerOptions.maxDate= new Date(_this.data('max-date'));
        }

        endPicker[name] = new Pikaday(datepickerOptions);

        _this.addClass('is-initialized');
    });

    $.each(startPicker, function (name, picker) {
        var _startDate = picker.getDate();

        if (_startDate) {
            startDate[name] = _startDate;
            updateStartDate(name);
        }
    });

    $.each(endPicker, function (name, picker) {
        var _endDate = picker.getDate();

        if (_endDate) {
            endDate[name] = _endDate;
            updateEndDate(name);
        }
    });
});
