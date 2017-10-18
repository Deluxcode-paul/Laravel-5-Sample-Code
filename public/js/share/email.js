var EmailShare = {
    selectors : {
        emailPopup: '.js-email-share-popup',
        emailForm: '.js-email-share-form',
        emailCancelButton: '.js-email-share-cancel-button',
        emailSubmitButton: '.js-email-share-submit-button',
        sharing: '.j-mailing-wrap'
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
        $(self.selectors.emailCancelButton).on('click', function(event) {
            event.preventDefault();
            self.hideEmailPopup();
        });
        $(self.selectors.emailSubmitButton).on('click', function(event) {
            event.preventDefault();
            self.sendEmail();
        });
    },
    showEmailPopup: function () {
        var self = this;
        $(self.selectors.emailPopup).removeClass(self.constants.hiddenClass);
        return false;
    },
    hideEmailPopup: function () {
        var self = this;
        $(self.selectors.emailForm)[0].reset();
        $(self.selectors.emailPopup).addClass(self.constants.hiddenClass);
        return false;
    },
    sendEmail: function () {
        var self = this;
        var $form = $(self.selectors.emailForm);
        $form.find('.error').remove();
        $.ajax({
            type: 'post',
            url: Front.routes.email,
            data: $form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                Front.showMessage(data.message, 'success');
                $(self.selectors.sharing).removeClass('open');
                $(self.selectors.sharing).find('input').val('');
            },
            error: function (jqXhr) {
                if (jqXhr.status === 422) {
                    //process validation errors here.
                    var data = jqXhr.responseJSON;
                    $.each(data, function (key, value) {
                        Front.showMessage(value[0], 'error');
                    });
                }
            }
        });
    }
};

$(document).ready(function () {
    EmailShare.init();
});