var DeletePost = {
    selectors : {
        deleteButton : '.js-delete-button'
    },
    init: function () {
        $(this.selectors.deleteButton).on('click', function (event) {
            var self = this;
            event.preventDefault();
            alertify.confirm('Confirmation', Front.translations.delete_post_confirmation,
                function () {
                    document.location.href = $(self).data('action');
                },
                function () {}
            );
        });
    }
};

$(document).ready(function () {
    DeletePost.init();
});