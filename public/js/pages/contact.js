;(function($, window, document, undefined) {

    var Contact = {
        elements: {},
        rating: function(){
            $(document).on('change', '.j-rating-radio input[type="radio"]', function(){
                $('.j-rating-radio').attr('data-rating', $(this).val());
            });
        },
        init: function(){
            var self = this;

            $('.j-contact-form').parsley();
            $('.j-ask-form').parsley();
            $('select').select2({
                theme: 'basic'
            });

            self.rating();
        }
    }

    Contact.init();

})(window.jQuery, window, document);