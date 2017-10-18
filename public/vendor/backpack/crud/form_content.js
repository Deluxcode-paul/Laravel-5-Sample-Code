$(document).keydown(function (e) {
    if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey)) {
        e.preventDefault();
        $("button[type=submit]").trigger('click');
        return false;
    }
    return true;
});

$(document).ready(function() {
    $('body').on('click', '#js-save-and-new', function() {
        $(this).prepend('<input type="hidden" name="redirect_after_save" value="'+$(this).data('route')+'" />');
    });
});