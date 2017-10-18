var GenerateMeal = {
    selectors : {
        select2 : '.js-select2'
    },
    init: function () {
        $(this.selectors.select2).select2();
    }
};

$(document).ready(function () {
    // GenerateMeal.init();
});