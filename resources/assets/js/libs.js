window.$ = window.jQuery = require('jquery');

window.enquire = require('enquire.js');

require('responsive-tabs');

require('outclick');

require('../../../node_modules/swiper/dist/js/swiper.jquery.js');

require('magnific-popup');

window.throttle = require('throttle-debounce/throttle');
window.debounce = require('throttle-debounce/debounce');

require('select2');

window.alertify = require('alertifyjs');

window.ParsleyConfig = {
    errorsContainer: function(field){
        var $field = $(field.$element),
            $container = $('<div class="form-item-errors" />');

        $container.prependTo($field.parent());
        return $container;
    }
}

require('parsleyjs');

window.loadImage = require('blueimp-load-image');