jQuery(document).ready(function ($) {
    $('.select2-array').each(function (i, obj) {
        if (!$(obj).data("select2")) {
            if (typeof $(obj).attr('placeholder') != 'undefined') {
                $(obj).select2({
                    placeholder: $(obj).attr('placeholder'),
                    allowClear: (typeof $(obj).attr('required') == 'undefined')
                });
            } else {
                $(obj).select2();
            }
        }
    });
});