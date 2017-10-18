jQuery(document).ready(function ($) {
    $('.select2-multiple').each(function (i, obj) {
        if (!$(obj).data("select2")) {
            var data = {};
            if (typeof $(obj).attr('placeholder') != 'undefined') {
                data.placeholder = $(obj).attr('placeholder');
            }
            if (typeof $(obj).attr('maximumSelectionSize') != 'undefined') {
                data.maximumSelectionSize = $(obj).attr('maximumSelectionSize');
            }
            $(obj).select2(data);
        }
    });
});