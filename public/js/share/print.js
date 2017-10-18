var Print = {
    selectors : {
        iframePrintId: '#printIFrame',
        iframePrint: {
            id: 'printIFrame',
            name: 'printIFrame',
            class: 'hide'
        }
    },
    print: function (src) {
        var self = this;
        self.selectors.iframePrint.src = src;
        $(self.selectors.iframePrintId).remove();
        var $body = $('body');
        $body.find(self.selectors.iframePrintId).remove();
        $body.append($('<iframe/>').attr(self.selectors.iframePrint));
        $(self.selectors.iframePrintId).off('load.print');
        $(self.selectors.iframePrintId).on('load.print', function() {
            var browserName = navigator.userAgent.toLowerCase();
            if (browserName.indexOf("trident") != -1) { //IE 11
                window.document.getElementById(self.selectors.iframePrint.name).contentWindow.document.execCommand('print', false, null);
            } else {
                window.frames[self.selectors.iframePrint.name].focus();
                window.frames[self.selectors.iframePrint.name].print();
            }
        });
    }
};