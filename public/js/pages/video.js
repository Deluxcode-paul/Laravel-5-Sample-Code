var Video = {
    selectors : {
        emailButton: '.js-email-video-button',
        saveButton : '.js-save-video-button'
    },
    constants: {
        hiddenClass: 'js-hidden'
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        // Email
        $(self.selectors.emailButton).on('click', function(event) {
            event.preventDefault();
            EmailShare.showEmailPopup();
        });
        // Save
        $(self.selectors.saveButton).on('click', function(event) {
            event.preventDefault();
            self.saveRecipe();
        });
    },
    saveRecipe : function () {
        var self = this;
        var _this = $(this);
        $.ajax({
            type: 'post',
            url: Front.routes.save,
            data: {
                'recipe': $(self.selectors.saveButton).data('recipe-id')
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                switch (res.status) {
                    case 'ok':
                        $('.js-save-recipe-wrapper').html(res.button);
                        Front.showMessage(res.message, 'success');
                        break;
                    case 'auth':
                        window.location.href = res.redirect;
                        break;
                    case 'error':
                        Front.showMessage(res.message, 'error');
                        break;
                    default:
                        Front.showMessage(res.message);
                        break;
                }
            },
            error: function () {
                Front.showMessage($(self.selectors.saveButton).data('error'), 'error');
            }
        });
    }
};

$(document).ready(function () {
    Video.init();
});