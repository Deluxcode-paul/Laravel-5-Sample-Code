$(function () {
    var templatesList = $('.templates-list');

    // add template item
    templatesList.on('click', '.template [data-action="add-item"]', function (e) {
        var templateItem = $(this).closest('.template');

        $.ajax({
            method: 'post',
            url: pageConstructor.config.routes.runCommand,
            data: {
                templateType: $(templateItem).find('input[name="templateType"]').val(),
                command: 'getItemForm',
                data: JSON.stringify({id: null})
            },
            success: function (res) {
                templateItem.find('.items').append(res);
                destroyCke();
                initCke();
                initDropzone();
                initSortable();
            }
        });
    });

    // remove template item
    templatesList.on('click', 'button[data-action="delete-item"]', function (e) {
        if (confirm('Are you sure you want to delete this item?')) {
            var templateItem = $(this).closest('.template-item');
            var templateItemId = $(templateItem).find('input[name="items[]"]').val();
            if (templateItemId != 0) {
                var preparedForDeletingHolder = $(templateItem).closest('.template').find('input[name="deleted-items"]');
                preparedForDeletingHolder.val(preparedForDeletingHolder.val() + '|' + templateItemId);
            }
            templateItem.remove();
        }
    });

    // collapse template item
    templatesList.on('click', 'button[data-action="collapse-item"]', function () {
        var item = $(this).closest('.template-item')[0];
        var boxBody = $(item).find('.cms-box-body')[0];

        if ($(boxBody).is(':visible')) {
            $(boxBody).slideUp();
            $(this).html('<i class="fa fa-chevron-left"></i>');
        } else {
            $(boxBody).slideDown();
            $(this).html('<i class="fa fa-chevron-down"></i>');
        }
    });
});