var AskQuestion = {
    selectors : {
        select2 : '.js-select2'
    },
    init: function () {
        $(this.selectors.select2).each(function (i, obj) {
            if (!$(obj).data("select2")) {
                var data = {};
                if (typeof $(obj).attr('s2_placeholder') != 'undefined') {
                    data.placeholder = $(obj).attr('s2_placeholder');
                }
                if (typeof $(obj).attr('maximumSelectionLength') != 'undefined') {
                    data.maximumSelectionLength = $(obj).attr('maximumSelectionLength');
                }
                $(obj).select2(data);
            }
        });
    }
};

$(document).ready(function () {
    AskQuestion.init();
});