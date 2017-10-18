backpack = backpack || {};
backpack.filters = {
    submit: function ($form) {
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: $form.serialize(),
            success: function () {
                window.location.href = window.location.href;
            }
        });
    },
    reset: function ($form) {
        $form.clearForm();
    }
};

$.fn.clearForm = function() {
    return this.each(function() {
        var type = this.type, tag = this.tagName.toLowerCase();
        if (tag == 'form')
            return $(':input',this).clearForm();
        if (type == 'text' || type == 'password' || tag == 'textarea')
            this.value = '';
        else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
        else if (tag == 'select')
            this.selectedIndex = 0;
    });
};

jQuery(document).ready(function ($) {
    var $backpackFilters = $('.backpack-filters');

    $backpackFilters.on('submit', '.form', function (e) {
        e.preventDefault();
        backpack.filters.submit($(this));
    });

    $backpackFilters.on('click', '#js-clear-filters', function (e) {
        e.preventDefault();
        var $form = $(this).parents('.form');
        backpack.filters.reset($form);
        backpack.filters.submit($form);
    });
});