$(function () {
    // hack for validation inputs with same names (http://stackoverflow.com/questions/931687/using-jquery-validate-plugin-to-validate-multiple-form-fields-with-identical-nam/4136430#4136430)
    $.validator.prototype.checkForm = function () {
        this.prepareForm();
        for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
            if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                    this.check(this.findByName(elements[i].name)[cnt]);
                }
            } else {
                this.check(elements[i]);
            }
        }
        return this.valid();
    };
    // extend jquery validator with filesize validation rule
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size/1000 <= param)
    }, 'File size must be less than {0} Kb');


    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : pageConstructor.config.csrfToken } });

    Dropzone.autoDiscover = false;

    var pageId = pageConstructor.config.pageId;
    var preparedForDeleting = [];

    var templatesList = $('.templates-list');

    initSortable();
    initCke();
    initTemplates();

    // preview
    $('a[data-action="preview"]').click(function (e) {
        e.preventDefault();
        var THIS = $(this);
        window.open(THIS.attr('href'), 'Preview', 'width=900,height=600,resizable,scrollbars');
    });

    // toggle visibility
    $('a[data-action="toggle-visibility"]').click(function (e) {
        e.preventDefault();

        var $this = $(this);
        var previewBtn = $('[data-action="preview"]');

        var currUrl = previewBtn.attr('href');
        previewBtn.attr('href', $this.data('otherUrl'));
        $this.data('otherUrl', currUrl);

        $this.html($this.data('enabled') ? '<i class="fa fa-eye"></i> Publish' : '<i class="fa fa-eye-slash"></i> Unpublish');
        $this.data('enabled', $this.data('enabled') ? 0 : 1);

        $.ajax({
            method: 'post',
            url: pageConstructor.config.routes.visibility,
            data: {pageId: pageId}
        });
    });

    // save page
    $('a[data-action="save"]').click(function (e) {
        e.preventDefault();
        var templateItems = document.getElementsByClassName('template');
        var valid = true;

        if (false == preparedForDeleting.length && false == templateItems.length) {
            return;
        }

        destroyCke();

        $('.template').each(function () {
            $(this).validate({
                ignore: ''
            });
            if (! $(this).valid()) {
                valid = false;
            }
        });

        if (!valid) {
            $.each($('input.error, textarea.error').closest('.template'), function () {
                if ($(this).data('collapsed')) {
                    $(this).data('collapsed', 0)
                        .find('.cms-box-body').slideDown();
                    $(this).find('button[data-action="collapse-template"]').html('<i class="fa fa-chevron-down"></i>');
                }
            });
            initCke();
            return;
        }

        $.blockUI({message: null});

        $(':checkbox:not(:checked)').each(function () {
            $(this).val($(this).data('uncheckedValue')).prop('checked', true);
        });

        if (preparedForDeleting.length > 0) {
            $.ajax({
                method: 'post',
                url: pageConstructor.config.routes.removeTemplates,
                data: {items: preparedForDeleting},
                success: function (res) {
                    window.location.reload();
                }
            });
        }

        if (false == templateItems.length) {
            return;
        }

        var data = new FormData();

        for (var i = 0; i < templateItems.length; i++) {
            data.append('templates[' + i + '][pageId]', pageId);

            var templateData = $(templateItems[i]).serializeArray();

            $.each(templateData, function (index, templateRow) {
                if (templateRow.name.substr(templateRow.name.length - 2) == '[]') {
                    data.append('templates[' + i + '][' + templateRow.name.substr(0, templateRow.name.length - 2) + '][]', templateRow.value);
                } else {
                    data.append('templates[' + i + '][' + templateRow.name + ']', templateRow.value);
                }
            });

            var fileFields = $(templateItems[i]).find('input[type="file"]');
            fileFields.each(function (index, fileField) {
                var fieldName = $(fileField).attr('name');
                if (fieldName.substr(fieldName.length - 2) == '[]') {
                    var items = $($(fileField).closest('.items')[0]).find('.template-item');
                    var itemIndex = $.inArray($(fileField).closest('.template-item')[0], items);
                    data.append('templates[' + i + '][' + fieldName.substr(0, fieldName.length - 2) + '][' + itemIndex + ']', fileField.files[0]);
                } else {
                    data.append('templates[' + i + '][' + fieldName + ']', fileField.files[0]);
                }
            });
        }

        $.ajax({
            method: 'post',
            url: pageConstructor.config.routes.saveTemplates,
            processData: false,
            contentType: false,
            data: data,
            success: function () {
                window.location.reload();
            }
        });
    });

    // add template
    $('li a', '.add-template-menu').on('click', function () {
        var templateType = $(this).data('type');
        $.blockUI({message: false});
        $.ajax({
            method: 'post',
            url: pageConstructor.config.routes.getForm,
            data: {
                templateType: templateType,
                pageId: pageId
            },
            success: function (res) {
                templatesList.append(res);
                destroyCke();
                initCke();
                initTemplates();
                $.unblockUI();
            }
        });
    });


    // remove template
    templatesList.on('click', '.template [data-action="remove"]', function (e) {
        if (confirm('Are you sure you want to delete this item?')) {
            var templateItem = $(this).closest('.template')[0];
            var templateId = $(templateItem).find('input[name="templateId"]').val();

            if(templateId != '0') {
                preparedForDeleting.push(templateId);
            }

            $(templateItem).remove();
        }
    });

    // collapse template
    templatesList.on('click', '.template [data-action="collapse-template"]', function (e) {
        var $this = $(this);
        var templateItem = $this.closest('.template')[0];

        if($(templateItem).data('collapsed')) {
            $(templateItem).data('collapsed', 0)
                .find('.cms-box-body').slideDown();
            $this.html('<i class="fa fa-chevron-down"></i>');
        } else {
            $(templateItem).data('collapsed', 1)
                .find('.cms-box-body').slideUp();
            $this.html('<i class="fa fa-chevron-left"></i>');
        }
    });

    // init templates
    function initTemplates() {
        pageConstructor.config.initialFunctions.forEach(function (funcName) {
            eval(funcName + '()');
        });
    }
});