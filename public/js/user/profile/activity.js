var Activity = {
    selectors : {
        reportAbuseButton: '.js-report-abuse',
        voteButton: '.js-vote',
        replyButton: '.js-reply-button',
        replyForm: '.js-reply-form',
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        $(document).on('click', self.selectors.reportAbuseButton, function(event) {
            event.preventDefault();
            self.reportAbuse(this);
        });
        $(document).on('click', self.selectors.voteButton, function(event) {
            event.preventDefault();
            self.vote(this);
        });
        $(self.selectors.replyButton).each(function() {
            $(this).on('click', function(event) {
                event.preventDefault();
                self.reply();
            });
        });
    },
    reportAbuse: function (element) {
        var self = this;
        var element = element;
        $.ajax({
            url: Front.routes.report_abuse,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'type': $(element).data('type'),
                'id' :  $(element).data('id')
            },
            method: 'post',
            success: function (res) {
                $(element).replaceWith(res.content);
                Front.showMessage(res.message, 'success');
            },
            error: function(res){
                Front.showMessage(Front.translations.report_abuse_error, 'error');
            },
            cache: true
        });
    },
    vote: function (element) {
        var self = this;
        var element = element;
        $.ajax({
            url: Front.routes.vote,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'type': $(element).data('type'),
                'id' :  $(element).data('id')
            },
            method: 'post',
            success: function (res) {
                $(element).replaceWith(res.content);
                Front.showMessage(res.message, 'success');
            },
            error: function(res){
                Front.showMessage(Front.translations.vote_error, 'error');
            },
            cache: true
        });
    },
    reply: function () {
        var self = this;
        $.ajax({
            url: $(self.selectors.replyForm).attr('action'),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(self.selectors.replyForm).serialize(),
            method: 'post',
            success: function (res) {
                // TODO: implement append of res.content
                Front.showMessage('Successfully posted', 'success');
            },
            error: function(res){
                Front.showMessage(res.responseText, 'error');
            },
            cache: true
        });
    }
};

$(document).ready(function () {
    Activity.init();
});