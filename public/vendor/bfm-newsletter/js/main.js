(function($) {
    $.fn.extend({
        newsletter: function (options) {
            options = $.extend({
                onError: function(message, data) {
                    Front.showMessage(message, 'error');
                },
                onSuccess: function(message, data) {
                    Front.showMessage(message, 'success');
                }
            }, options);

            $(this).submit(function (event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.error) {
                            options.onError(response.error);
                        } else {
                            options.onSuccess(response.message);
                            $('#js-newsletter input').val('');
                        }
                    },
                    error: function(jqXHR, textStatus, errorMessage) {
                        options.onError(errorMessage);
                    }
                });
            });
        }
    });
})(jQuery);
