var Account = {
    selectors : {
        aboutContainer: '.js-about-container',
        socialContainer: '.js-social-container',
        preferencesContainer: '.js-preferences-container',

        aboutView: '.js-account-about-view',
        aboutEdit: '.js-account-about-edit-container',
        aboutForm: '.js-account-about-form',
        aboutEditButton: '.js-account-about-edit',
        aboutCancelButton: '.js-account-about-cancel',
        aboutSaveButton: '.js-account-about-save',

        socialView: '.js-account-social-view',
        socialEdit: '.js-account-social-edit-container',
        socialForm: '.js-account-social-form',
        socialEditButton: '.js-account-social-edit',
        socialCancelButton: '.js-account-social-cancel',
        socialSaveButton: '.js-account-social-save',

        preferencesView: '.js-account-preferences-view',
        preferencesEdit: '.js-account-preferences-edit-container',
        preferencesForm: '.js-account-preferences-form',
        preferencesEditButton: '.js-account-preferences-edit',
        preferencesCancelButton: '.js-account-preferences-cancel',
        preferencesSaveButton: '.js-account-preferences-save',

        deleteAccountButton: '.js-account-delete',
        deleteAccountForm: '.js-delete-account-form',

        resendConfirmationButton: '.js-resend-email-confirmation',

        stateContainer: '.js-state-container',
        countrySelect: '#country_id',
        stateSelect: '#state_id',

        subscriptionForm: '.js-subscription-form',
        subscriptionCheckbox: '.js-subscription-checkbox'
    },
    init: function () {
        var self = this;
        self.bindEvents();
        self.initForms();
        Parsley.options.errorsContainer = function(field){
            var $field = $(field.$element),
                $container = $('<div class="form-item-errors" />');

            $container.appendTo($field.parent());
            return $container;
        };
    },
    initAbout: function() {
        var self = this;
        var $document = $(document);
        var $aboutForm = $(self.selectors.aboutContainer).find(self.selectors.aboutForm);

        $document.on('click', self.selectors.aboutEditButton, function(event) {
            event.preventDefault();
            self.loadAbout();
        });
        $document.on('click', self.selectors.aboutCancelButton, function(event) {
            event.preventDefault();
            self.show(self.selectors.aboutView);
            self.hide(self.selectors.aboutEdit);
        });
        $document.on('click', self.selectors.aboutSaveButton, function(event) {
            event.preventDefault();

            var parsley = $aboutForm.parsley();
            parsley.validate();

            if (parsley.isValid()) self.saveAbout();
        });
    },
    initSocials: function() {
        var self = this;
        var $document = $(document);
        var $socialsForm = $(self.selectors.socialContainer).find(self.selectors.socialForm);

        $document.on('click', self.selectors.socialEditButton, function(event) {
            event.preventDefault();
            self.loadSocial();
        });
        $document.on('click', self.selectors.socialCancelButton, function(event) {
            event.preventDefault();
            self.show(self.selectors.socialView);
            self.hide(self.selectors.socialEdit);
        });
        $document.on('click', self.selectors.socialSaveButton, function(event) {
            event.preventDefault();

            var parsley = $socialsForm.parsley();
            parsley.validate();

            if (parsley.isValid()) self.saveSocial();
        });
    },
    initPreferences: function() {
        var self = this;
        var $document = $(document);

        $document.on('click', self.selectors.preferencesEditButton, function(event) {
            event.preventDefault();
            self.loadPreferences();
        });
        $document.on('click', self.selectors.preferencesCancelButton, function(event) {
            event.preventDefault();
            self.show(self.selectors.preferencesView);
            self.hide(self.selectors.preferencesEdit);
        });
        $document.on('click', self.selectors.preferencesSaveButton, function(event) {
            event.preventDefault();
            self.savePreferences();
        });
    },
    bindEvents: function () {
        var self = this;
        if (!is_confirmed) {
            $(self.selectors.subscriptionCheckbox).prop('disabled', true);
        }

        self.initAbout();
        self.initSocials();
        self.initPreferences();

        $(self.selectors.deleteAccountButton).on('click', function(event) {
            event.preventDefault();
            alertify.confirm('Confirmation', Front.translations.delete_account_confirmation,
                function () {
                    self.deleteAccount();
                },
                function () {}
            );
        });
        $(self.selectors.aboutContainer).on('change', self.selectors.countrySelect, function() {
            self.checkCountry();
        });
        $(self.selectors.subscriptionCheckbox).change(function() {
            self.changeSubscription();
        });
        $(self.selectors.resendConfirmationButton).on('click', function(event) {
            event.preventDefault();
            self.resendConfirmation();
        });
        self.checkCountry();
    },
    show: function(element) {
        $(element).removeClass('js-hidden');
    },
    hide: function(element) {
        $(element).addClass('js-hidden');
    },
    checkCountry: function() {
        var self = this;
        if ($(self.selectors.countrySelect).val() == Front.constants.USA_ID) {
            self.show(self.selectors.stateContainer);
        } else {
            self.hide(self.selectors.stateContainer);
            $(self.selectors.stateSelect).val('');
        }
    },
    deleteAccount: function() {
        var self = this;
        $(self.selectors.deleteAccountForm).submit();
    },
    changeSubscription: function () {
        var self = this;
        $.ajax({
            url: $(self.selectors.subscriptionForm).attr('action'),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(self.selectors.subscriptionForm).serialize(),
            method: 'post',
            success: function (res) {
                $(self.selectors.subscriptionCheckbox).prop('disabled', false);
                Front.showMessage(res.status, 'success');
            },
            error: function(res){
                $(self.selectors.subscriptionCheckbox).prop('disabled', false);
                Front.showMessage(Front.translations.subscription_error, 'error');
            },
            cache: true
        });
        $(self.selectors.subscriptionCheckbox).prop('disabled', true);
    },
    loadAbout: function () {
        var self = this;
        $.ajax({
            url: Front.routes.about_edit,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            success: function (res) {
                $(self.selectors.aboutEditButton).prop('disabled', false);
                $(self.selectors.aboutEdit).remove();
                $(self.selectors.aboutContainer).append(res.content);

                if (res.isChef) {
                    self.checkCountry();
                    $(self.selectors.aboutForm).parsley();
                    $('select').select2({
                        theme: 'basic'
                    });
                    
                    var $item = $('.j-texterea-length');

                    if($item.length){
                        $.each($item, function() {
                            var $textarea = $(this).find('textarea'),
                                $output = $(this).find('output');
                                
                            $output.text($textarea.val().length);
                        });
                    }
                }

                self.show(self.selectors.aboutEdit);
                self.hide(self.selectors.aboutView);
            },
            error: function(res){
                $(self.selectors.aboutEditButton).prop('disabled', false);
                Front.showMessage(Front.translations.load_error, 'error');
            },
            cache: true
        });
        $(self.selectors.aboutEditButton).prop('disabled', true);
    },
    loadSocial: function () {
        var self = this;
        $.ajax({
            url: Front.routes.social_edit,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            success: function (res) {
                $(self.selectors.socialEditButton).prop('disabled', false);
                $(self.selectors.socialEdit).remove();
                $(self.selectors.socialContainer).append(res.content);
                $(self.selectors.socialForm).parsley();
                self.show(self.selectors.socialEdit);
                self.hide(self.selectors.socialView);
            },
            error: function(res){
                $(self.selectors.socialEditButton).prop('disabled', false);
                Front.showMessage(Front.translations.load_error, 'error');
            },
            cache: true
        });
        $(self.selectors.socialEditButton).prop('disabled', true);
    },
    loadPreferences: function () {
        var self = this;
        $.ajax({
            url: Front.routes.preferences_edit,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            success: function (res) {
                $(self.selectors.preferencesEditButton).prop('disabled', false);
                $(self.selectors.preferencesEdit).remove();
                $(self.selectors.preferencesContainer).append(res.content);
                self.show(self.selectors.preferencesEdit);
                self.hide(self.selectors.preferencesView);
            },
            error: function(res){
                $(self.selectors.preferencesEditButton).prop('disabled', false);
                Front.showMessage(Front.translations.load_error, 'error');
            },
            cache: true
        });
        $(self.selectors.preferencesEditButton).prop('disabled', true);
    },
    saveAbout: function () {
        var self = this;
        $.ajax({
            url: $(self.selectors.aboutForm).attr('action'),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(self.selectors.aboutForm).serialize(),
            method: 'post',
            success: function (res) {
                $(self.selectors.aboutSaveButton).prop('disabled', false);
                $(self.selectors.aboutCancelButton).prop('disabled', false);
                if (res.error) {
                    $(self.selectors.aboutEdit).remove();
                    $(self.selectors.aboutContainer).append(res.content);
                    $('select').select2({
                        theme: 'basic'
                    });
                } else {
                    $(self.selectors.aboutView).remove();
                    $(self.selectors.aboutContainer).prepend(res.content);
                    $(self.selectors.aboutCancelButton).trigger('click');
                    Front.showMessage(Front.translations.save_success, 'success');
                }
            },
            error: function(res){
                $(self.selectors.aboutSaveButton).prop('disabled', false);
                $(self.selectors.aboutCancelButton).prop('disabled', false);
                Front.showMessage(Front.translations.save_error, 'error');
            },
            cache: true
        });
        $(self.selectors.aboutSaveButton).prop('disabled', true);
        $(self.selectors.aboutCancelButton).prop('disabled', true);
    },
    saveSocial: function () {
        var self = this;
        $.ajax({
            url: $(self.selectors.socialForm).attr('action'),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(self.selectors.socialForm).serialize(),
            method: 'post',
            success: function (res) {
                $(self.selectors.socialSaveButton).prop('disabled', false);
                $(self.selectors.socialCancelButton).prop('disabled', false);
                if (res.error) {
                    $(self.selectors.socialEdit).remove();
                    $(self.selectors.socialContainer).append(res.content);
                } else {
                    $(self.selectors.socialView).remove();
                    $(self.selectors.socialContainer).prepend(res.content);
                    $(self.selectors.socialCancelButton).trigger('click');
                    Front.showMessage(Front.translations.save_success, 'success');
                }
            },
            error: function(res){
                $(self.selectors.socialSaveButton).prop('disabled', false);
                $(self.selectors.socialCancelButton).prop('disabled', false);
                Front.showMessage(Front.translations.save_error, 'error');
            },
            cache: true
        });
        $(self.selectors.socialSaveButton).prop('disabled', true);
        $(self.selectors.socialCancelButton).prop('disabled', true);
    },
    savePreferences: function () {
        var self = this;
        $.ajax({
            url: $(self.selectors.preferencesForm).attr('action'),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(self.selectors.preferencesForm).serialize(),
            method: 'post',
            success: function (res) {
                $(self.selectors.preferencesSaveButton).prop('disabled', false);
                $(self.selectors.preferencesCancelButton).prop('disabled', false);
                if (res.error) {
                    $(self.selectors.preferencesEdit).remove();
                    $(self.selectors.preferencesContainer).append(res.content);
                } else {
                    $(self.selectors.preferencesView).remove();
                    $(self.selectors.preferencesContainer).prepend(res.content);
                    $(self.selectors.preferencesCancelButton).trigger('click');
                    Front.showMessage(Front.translations.save_success, 'success');
                }
            },
            error: function(res){
                $(self.selectors.preferencesSaveButton).prop('disabled', false);
                $(self.selectors.preferencesCancelButton).prop('disabled', false);
                Front.showMessage(Front.translations.save_error, 'error');
            },
            cache: true
        });
        $(self.selectors.preferencesSaveButton).prop('disabled', true);
        $(self.selectors.preferencesCancelButton).prop('disabled', true);
    },
    resendConfirmation: function () {
        var self = this;
        $.ajax({
            url: Front.routes.resend_confirmation,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            success: function (res) {
                Front.showMessage(res.message, 'success');
            },
            error: function(res){
                Front.showMessage(Front.translations.send_email_error, 'error');
            },
            cache: true
        });
    },
    initForms: function () {
        var self = this;
        $(self.selectors.aboutForm).parsley();
        $(self.selectors.socialForm).parsley();
    }
};

$(document).ready(function () {
    Account.init();
});