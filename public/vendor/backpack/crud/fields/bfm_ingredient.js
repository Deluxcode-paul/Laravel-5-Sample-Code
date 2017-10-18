jQuery(document).ready(function ($) {
    $('.select2-ingredient').each(function (i, obj) {
        if (!$(obj).data("select2")) {
            $(obj).select2({
                tags: true,
                tokenSeparators: [$(obj).data('separator')],
                createSearchChoice: function (term, data) {
                    if ($(data).filter(function () {
                            return this.text.localeCompare(term) === 0;
                        }).length === 0) {
                        return {
                            id: term,
                            text: term
                        };
                    }
                },
                multiple: false,
                maximumSelectionSize: 1,
                ajax: {
                    url: backpack.ajax.TagsUrl,
                    dataType: 'json',
                    data: function (term) {
                        return {
                            query: term,
                            model: $(obj).data('model'),
                            attribute: $(obj).data('attribute')
                        };
                    },
                    results: function (data) {
                        return {
                            results: data
                        };
                    }
                },
                initSelection: function (element, callback) {
                    var data = [];

                    function splitVal(string, separator) {
                        var val, i, l;
                        if (string === null || string.length < 1) return [];
                        val = string.split(separator);
                        for (i = 0, l = val.length; i < l; i = i + 1) val[i] = $.trim(val[i]);
                        return val;
                    }

                    $(splitVal(element.val(), ",")).each(function () {
                        data.push({
                            id: this,
                            text: this
                        });
                    });

                    callback(data);
                }
            });
        }
    });
});