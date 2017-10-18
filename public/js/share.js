(function ($) {

    $(document).ready(function() {
        Front.share = Front.share || {};
        Front.share.mailTo = {
            selectors: {
                buttonOpen:  '.js-mail-to',
                buttonClose: '.js-mail-to-cancel',
                buttonSubmit: '.js-mail-to-submit',
                popup: '.js-mail-to-popup',
                form: '.js-mail-to-form',
                buttonShare: '.j-action-share .j-mailing',
                share: '.j-action-share .j-mailing-wrap',
                shareWrap: '.j-action-share',
                buttonSocial: '.j-action-share .j-sharing',
                social: '.j-action-share .j-sharing-wrap'
            },
            popupOpen: function () {
                $(Front.share.mailTo.selectors.popup).show();
                return false;
            },
            popupClose: function () {
                $(Front.share.mailTo.selectors.form)[0].reset();
                $(Front.share.mailTo.selectors.popup).hide();
                return false;
            },
            popupSubmit: function () {

                var $form = $(Front.share.mailTo.selectors.form);

                $form.find('.error').remove();

                $.ajax({
                    type: 'post',
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Front.showMessage(data.message, data.type);
                    },
                    error: function (jqXhr) {
                        if (jqXhr.status === 422) {
                            //process validation errors here.
                            var data = jqXhr.responseJSON;
                            $.each(data, function (key, value) {
                                $('input[name='+key+']').after('<span class="error">' + value[0] + '</span>');
                            });
                        }
                    }

                });
            }
        };

        $(document)
            .off('click.mail-to-open')
            .off('click.mail-to-close')
            .off('click.mail-to-submit');

        $(document)
            .on('click.mail-to-open', Front.share.mailTo.selectors.buttonOpen, function (e){
                e.preventDefault();
                return Front.share.mailTo.popupOpen();
            })
            .on('click.mail-to-close', Front.share.mailTo.selectors.buttonClose, function (e){
                e.preventDefault();
                return Front.share.mailTo.popupClose();
            })
            .on('click.mail-to-submit', Front.share.mailTo.selectors.buttonSubmit, function (e){
                e.preventDefault();
                return Front.share.mailTo.popupSubmit();
            })
            .on('click', Front.share.mailTo.selectors.buttonShare, function (){
                $(Front.share.mailTo.selectors.share).toggleClass('open');
                $(Front.share.mailTo.selectors.share)[0].addEventListener('outclick', function(e){
                    $(Front.share.mailTo.selectors.share).removeClass('open');
                });
            })
            
        ;
        enquire.register("screen and (max-width:1025px)", {
            match : function() {
                $(document).on('click', Front.share.mailTo.selectors.buttonSocial, function (){
                    $(Front.share.mailTo.selectors.social).toggleClass('open');
                    $(Front.share.mailTo.selectors.social)[0].addEventListener('outclick', function(e){
                        $(Front.share.mailTo.selectors.social).removeClass('open');
                    });
                })
            }
        });
    });

})(jQuery);
