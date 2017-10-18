jQuery(document).ready(function ($) {
    $('.select2').each(function (i, obj) {
        if (!$(obj).data("select2")) {
            if (typeof $(obj).attr('placeholder') != 'undefined') {
                $(obj).select2({
                    placeholder: $(obj).attr('placeholder'),
                    allowClear: (typeof $(obj).attr('required') == 'undefined'),
                    minimumResultsForSearch: 10
                });
            } else {
                $(obj).select2({
                    minimumResultsForSearch: 10
                });
            }
        }
    });
});
