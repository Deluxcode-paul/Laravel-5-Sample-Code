function processSelectedFile(filePath, requestingField) {
    $('#' + requestingField).val(filePath);
}

$(document).on('click', '.popup_selector', function (event) {
    event.preventDefault();
    $.colorbox({
        href: backpack.elfinder.prefixUrl + '/popup/' + $(this).data('inputid'),
        fastIframe: true,
        iframe: true,
        width: '70%',
        height: '50%'
    });
});

$(document).on('click', '.clear_elfinder_picker', function (event) {
    event.preventDefault();
    var updateID = $(this).attr('data-inputid');
    $('#' + updateID).val('');
});