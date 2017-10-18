var SocialShare = {
    selectors : {
        container: '.bfm-share',
        button: 'a'
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        $(self.selectors.container).find(self.selectors.button).each(function (){
            $(this).on('click', function() {
                self.shareAction();
            });
        });
    },
    shareAction: function () {
        $.ajax({
            type: 'post',
            url: Front.routes.share,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
            },
            error: function () {
            }
        });
    }
};

$(document).ready(function () {
    SocialShare.init();
});