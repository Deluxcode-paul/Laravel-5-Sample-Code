var Recipe = {
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        function ajaxOn() {
            $('body').addClass('is-loading');
        }

        function ajaxOff() {
            $('body').removeClass('is-loading');
        }

        $(document)
            .on('click', '.js-load-more-button', function () {
                var container = $(this).data('container'),
                    url = $(this).attr('href'),
                    errorMessage = $(this).data('error'),
                    loadMoreButton = $(this);
                ajaxOn();
                $.ajax({
                    url: url,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    success: function (res) {
                        $(container).append(res.content);
                        if (!res.hasMorePages) {
                            $(loadMoreButton).remove();
                        } else {
                            loadMoreButton.attr('href', res.link);
                        }
                    },
                    error: function () {
                        Front.showMessage(errorMessage, 'error');
                    },
                    complete: function () {
                        ajaxOff();
                    },
                    cache: true
                });

                return false;
            })
            .on('click', '.js-add-community', function () {
                var button = $(this);
                var container = $(this).parent().find('.js-community-edit-container');
                ajaxOn();
                $.ajax({
                    url: button.data('link'),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'get',
                    success: function (res) {
                        button.hide();
                        container.html(res.content).show();
                        $('.js-select2').select2({
                            theme: 'basic is-inline'
                        });
                    },
                    error: function () {
                        Front.showMessage(errorMessage, 'error');
                    },
                    complete: function () {
                        ajaxOff();
                    }
                });

                return false;
            })
            .on('click', '.js-community-cancel', function () {
                var container = $(this).closest('.js-community-edit-container');
                var button = container.parent().find('.js-add-community');
                // Hide form
                button.show();
                container.hide();
                // Reset fields
                container.find('form').reset();

                return false;
            })
            .on('click', '.js-community-submit', function () {
                var container = $(this).closest('.js-community-edit-container'),
                    listContainer = $(this).data('container'),
                    button = container.parent().find('.js-add-community'),
                    $form = container.find('form'),
                    errorMessage = $(this).data('error'),
                    id = container.find(".js-form-hidden-id").val();
                ajaxOn();
                $.ajax({
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    success: function (res) {
                        if (id > 0) {
                            $(listContainer).find('.js-community-' + id).html(res.content);
                        } else {
                            $(listContainer).prepend(res.content);
                        }
                        // Hide form
                        button.show();
                        container.hide();
                    },
                    error: function () {
                        Front.showMessage(errorMessage, 'error');
                    },
                    complete: function () {
                        ajaxOff();
                    }
                });

                return false;
            });
    }
};
jQuery(window).ready(function () {
    Recipe.init();
});
