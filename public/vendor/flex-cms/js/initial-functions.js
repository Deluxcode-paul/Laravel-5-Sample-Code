function initCke() {
    $('.cke').each(function (index, elem) {
        var ckeInstanceId = $(elem).attr('id');
        if (!CKEDITOR.instances[ckeInstanceId]) {
            CKEDITOR.replace(ckeInstanceId, {
                language: 'en',
                title: false,
                toolbarGroups: [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                    { name: 'forms', groups: [ 'forms' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                    { name: 'links', groups: [ 'links' ] },
                    { name: 'insert', groups: [ 'insert' ] },
                    { name: 'styles', groups: [ 'styles' ] },
                    { name: 'colors', groups: [ 'colors' ] },
                    { name: 'tools', groups: [ 'tools' ] },
                    { name: 'others', groups: [ 'others' ] },
                    { name: 'about', groups: [ 'about' ] }
                ],
                removeButtons: 'Save,NewPage,Preview,Print,Templates,Find,Replace,Scayt,SelectAll,Form,HiddenField,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,Smiley,PageBreak,Iframe,TextColor,BGColor,Maximize,ShowBlocks,About,Styles,Font,FontSize',
                extraAllowedContent: 'iframe[*]'
            });

            AjexFileManager.init({
                returnTo: 'ckeditor',
                editor: CKEDITOR.instances[ckeInstanceId],
                lang: 'en'
            });
        }
    });
}

function destroyCke() {
    $('.cke').each(function (index, elem) {
        var ckeInstanceId = $(elem).attr('id');
        if (CKEDITOR.instances[ckeInstanceId]) {
            CKEDITOR.instances[ckeInstanceId].destroy();
            CKEDITOR.remove(ckeInstanceId);
        }
    });
}

function initDropzone() {
    $('.dropzone').each(function () {
        var template = $(this).closest('.template');
        try{
            $(this).dropzone({
                url: pageConstructor.config.routes.runCommand,
                dictDefaultMessage: 'Drop files or click here to create new slides',
                acceptedFiles: '.jpg,.jpeg,.gif,.png',
                headers: { 'X-CSRF-TOKEN' :  $('meta[name="csrf-token"]').attr('content')},
                previewsContainer: '.dropzone-preview',
                accept: function (file, done) {
                    var maxFileSize = pageConstructor.config.imageMaxFileSize;
                    var fileSize = file.size/1000;

                    done((fileSize >= maxFileSize) ? 'File size is too big' : null);
                },
                error: function (file, message) {
                    alert(message);
                },
                sending: function (file, xhr, formData) {
                    $.blockUI({ message: null });

                    formData.append('templateType', template.find('input[name="templateType"]').val());
                    formData.append('command', 'addNewImage');
                    formData.append('data', file);
                },
                success: function (e, res) {
                    template.find('.items').append(res);
                },
                queuecomplete: function (e, res) {
                    $.unblockUI();
                }
            });
        } catch (error) {}
    });
}

function initSortable() {
    $('.sortable').sortable({
        handle: '.sortable-area',
        start: function(event, ui){
            destroyCke();
        },
        stop: function(event, ui){
            initCke();
        }
    });
}