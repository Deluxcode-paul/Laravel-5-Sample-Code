jQuery(document).ready(function ($) {
    $('.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: backpack.crud.sortable.maxLevels,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: false
    });

    $('.disclose').on('click', function () {
        $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
    });

    $('#toArray').click(function (e) {
        arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
        $.ajax({
            url: backpack.requestUrl,
            type: 'POST',
            data: {tree: arraied}
        })
        .done(function () {
            new PNotify({
                title: backpack.lang.notification.reorderSuccess.title,
                text: backpack.lang.notification.reorderSuccess.message,
                type: "success"
            });
        })
        .fail(function () {
            new PNotify({
                title: backpack.lang.notification.reorderError.title,
                text: backpack.lang.notification.reorderError.message,
                type: "danger"
            });
        })
        .always(function () {});
    });

    $.ajaxPrefilter(function (options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');
        if (token) {
            return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });
});