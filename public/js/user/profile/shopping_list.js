var ShoppingList = {
    checkedAll: true,
    selectors : {
        pdfButton: '.js-pdf-recipe-button',
        printButton: '.js-print-recipe-button',
        deleteRecipeButton: '.js-delete-recipe-button',
        deleteIngredientButton: '.js-delete-ingredient-button',
        checkbox: '.js-recipe-checkbox',
        form: '.js-recipe-form',
        ingredientContainer: 'li',
        emailButton: '.js-email-recipe-button',
        emailPopup: '.js-email-share-popup',
        emailForm: '.js-email-share-form',
        emailCancelButton: '.js-email-share-cancel-button',
        emailSubmitButton: '.js-email-share-submit-button',
        shoppingListWrapper: '.js-shopping-list-wrapper'
    },
    constants: {
        hiddenClass: 'js-hidden',
        printKeyCode: 80
    },
    init: function () {
        var self = this;
        self.bindEvents();
    },
    bindEvents: function () {
        var self = this;
        // Delete recipe
        $(self.selectors.deleteRecipeButton).on('click', function(event) {
            event.preventDefault();
            if (!self.checkChecked()) {
                self.showNoCheckedMessage();
            } else {
                alertify.confirm('Confirmation', Front.translations.delete_recipe_confirmation,
                    function () {
                        self.submitForm(Front.routes.delete_recipe);
                    },
                    function () {}
                );
            }
        });
        // Pdf
        $(self.selectors.pdfButton).on('click', function(event) {
            event.preventDefault();
            if (!self.checkChecked()) {
                self.showNoCheckedMessage();
            } else {
                self.submitForm(Front.routes.pdf);
            }
        });
        // Delete ingredient
        $(self.selectors.deleteIngredientButton).on('click', function(event) {
            event.preventDefault();
            var $this = $(this);
            alertify.confirm('Confirmation', Front.translations.delete_ingredient_confirmation,
                function () {
                    self.deleteIngredient($this);
                },
                function () {}
            );
        });
        // Print
        $(document).off('click.print');
        $(document).on('click.print', self.selectors.printButton, function (e) {
            e.preventDefault();
            if (!self.checkChecked()) {
                self.showNoCheckedMessage();
            } else {
                Print.print(Front.routes.print + '?' + $(self.selectors.form).serialize());
            }
        });

        $(document).off('keydown.print');
        $(document).on('keydown.print', function(e){
            if ((e.ctrlKey && e.keyCode == self.constants.printKeyCode)
                && $(self.selectors.printButton).length > 0) {
                e.preventDefault();
                if (!self.checkChecked()) {
                    self.showNoCheckedMessage();
                } else {
                    Print.print(Front.routes.print + '?' + $(self.selectors.form).serialize());
                }
                return false;
            }
        });
        // Email
        $(self.selectors.emailButton).on('click', function(event) {
            event.preventDefault();
            self.showEmailPopup();
        });
        $(self.selectors.emailCancelButton).on('click', function(event) {
            event.preventDefault();
            self.hideEmailPopup();
        });
        $(self.selectors.emailSubmitButton).on('click', function(event) {
            event.preventDefault();
            if (!self.checkChecked()) {
                self.showNoCheckedMessage();
            } else {
                self.sendEmail();
                self.disableSendEmailButton();
            }
        });
    },
    checkChecked : function () {
        var self = this;
        return $(self.selectors.checkbox + ':checked').length;
    },
    showNoCheckedMessage : function () {
        Front.showMessage(Front.translations.no_recipes_selected, 'warning');
    },
    submitForm : function (action) {
        var self = this;
        $(self.selectors.form).attr('action', action).submit();
    },
    deleteIngredient: function ($element) {
        var self = this;
        $.ajax({
            url: Front.routes.delete_ingredient,
            data: {
                id: $element.data('id'),
                page: $(self.selectors.shoppingListWrapper).data('page')
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'post',
            success: function (res) {
                var count = $element.parents('ul').find('li').length;
                $element.parents(self.selectors.ingredientContainer).remove();
                if (1 == count) {
                    window.location.href = res.redirect;
                }
            },
            error: function(res){
                Front.showMessage(Front.translations.delete_ingredient_error, 'error');
            },
            cache: true
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
        $(self.selectors.emailPopup).find('.error').remove();
        $(self.selectors.emailPopup).addClass(self.constants.hiddenClass);
        return false;
    },
    sendEmail: function () {
        var self = this;
        var $form = $(self.selectors.emailForm);
        $form.find('.error').remove();
        $.ajax({
            type: 'post',
            url: Front.routes.email + '?' + $(self.selectors.form).serialize(),
            data: $form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                self.enableSendEmailButton();
                Front.showMessage(data.message, data.type);
                self.hideEmailPopup();
            },
            error: function (jqXhr) {
                self.enableSendEmailButton();
                if (jqXhr.status === 422) {
                    var data = jqXhr.responseJSON;
                    $.each(data, function (key, value) {
                        $form.find('input[name='+key+']').before('<span class="error">' + value[0] + '</span>');
                    });
                }
            }
        });
    },
    enableSendEmailButton: function () {
        var self = this;
        $(self.selectors.emailSubmitButton).removeAttr('disabled');
    },
    disableSendEmailButton: function () {
        var self = this;
        $(self.selectors.emailSubmitButton).attr('disabled', 'disabled');
    }
};

$(document).ready(function () {
    ShoppingList.init();
});