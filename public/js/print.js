(function ($) {

    $(document).ready(function() {

        Front.recipe = Front.recipe || {};
        Front.recipe.print = {
            selectors: {
                printBtn: '#printButton',
                iframePrintId: '#printIFrame',
                iframePrint: {
                    id: 'printIFrame',
                    name: 'printIFrame',
                    class: 'hide'
                }
            },
            constants: {
                printKeyCode: 80
            },
            print: function () {
                Front.recipe.print.selectors.iframePrint.src = $('#js_printUrl').val();

                $(Front.recipe.print.selectors.iframePrintId).remove();
                var $body = $('body');
                $body.find('#printIFrame').remove();
                $body.append($('<iframe/>').attr(Front.recipe.print.selectors.iframePrint));
                $(Front.recipe.print.selectors.iframePrintId).off('load.print');
                $(Front.recipe.print.selectors.iframePrintId).on('load.print', function() {
                    var browserName = navigator.userAgent.toLowerCase();
                    if (browserName.indexOf("trident") != -1) { //IE 11
                        window.document.getElementById(Front.recipe.print.selectors.iframePrint.name).contentWindow.document.execCommand('print', false, null);
                    } else {
                        window.frames[Front.recipe.print.selectors.iframePrint.name].focus();
                        window.frames[Front.recipe.print.selectors.iframePrint.name].print();
                    }
                });
            }
        };
        $(document).off('click.print');
        $(document).on('click.print', Front.recipe.print.selectors.printBtn, function (e) {
            e.preventDefault();
            Front.recipe.print.print();
        });

        $(document).off('keydown.print');
        $(document).on('keydown.print', function(e){
            if ((e.ctrlKey && e.keyCode == Front.recipe.print.constants.printKeyCode)
                && $(Front.recipe.print.selectors.printBtn).length > 0) {
                e.preventDefault();
                Front.recipe.print.print();
                return false;
            }
        });
    });
})(jQuery);