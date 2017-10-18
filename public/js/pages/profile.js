;(function($, window, document, undefined) {

    var Profile = {
        elements: {},
        init: function(){
            var self = this;
            self.bindEvents();

            $('.j-shopping-item .js-recipe-checkbox:checked').closest('.j-shopping-item').addClass('is-checked');

            self.textareaLength();
            self.avatarUpload();
        },

        textareaLength: function () {
            var $item = $('.j-texterea-length');

            if($item.length){
                $.each($item, function() {
                    var $textarea = $(this).find('textarea'),
                        $output = $(this).find('output');
                        
                    $output.text($textarea.val().length);
                });
            }
        },
        textareaLengthSingle: function ($item) {
            var $textarea = $item.find('textarea'),
                $output = $item.find('output');
                        
            $output.text($textarea.val().length);
        },
        avatarUpload: function() {
            var $wrap = $('.aside__avatar'),
                $form = $wrap.find('#js-form-avatar'),
                $input = $form.find('.js-inputfile'),
                maxSize = $input.data('maxSize'),
                allowedExt = ($input.attr('accept') || '.jpg, .jpeg, .gif, .png'),
                allowedExtArr = allowedExt.replace(/\./g, '').split(', '),
                $previewArea = $form.find('.photo'),
                $actions = $form.find('.form-actions'),
                $oldImg = $form.find('.img-preview'),
                options = {
                    maxWidth: 160,
                    maxHeight: 160,
                    cover: true,
                    crop: true
                };

            $actions.hide();

            $input.on('change', function(e){
                if (typeof (FileReader) == 'undefined') return;
                e.preventDefault();

                $actions.hide();

                var file = e.target.files[0],
                    _o = $.extend({}, options),
                    hasError = false;

                if (allowedExtArr && (!file.name.toLowerCase().hasExtension(allowedExtArr))) {
                    Front.showMessage('Incorrect file type. Please use jpg, jpeg, png, gif.', 'error');
                    hasError = true;
                }

                if (file.size == 0 || (maxSize && (file.size / 1000) > maxSize)) {
                    Front.showMessage('Uploaded file is too large. It should be under '+maxSize/1024+' Mb.', 'error');
                    hasError = true;
                }

                if (hasError) {
                    $previewArea.empty().append($oldImg);
                    return;
                }

                $wrap.addClass('is-loading');

                loadImage.parseMetaData(file, function(data){
                    if (data.exif) _o.orientation = data.exif.get('Orientation');
                    loadImage(file, function(img){
                        $newItem = $(img);
                        $newItem.addClass('img-preview');
                        $oldImg.detach();
                        $previewArea.empty();
                        $previewArea.prepend($newItem);
                        $actions.slideDown();
                        $wrap.removeClass('is-loading');
                    }, _o);
                });

            });
        },

        bindEvents: function () {
            var self = this;
            $('select').select2({
                theme: 'basic'
            });

            $(document)
                .on('input', '.j-texterea-length textarea', function () {
                    self.textareaLengthSingle($(this).closest('.j-texterea-length'));
                })
                .on('click', '.j-shopping-expand', function () {
                    $(this).closest('.j-shopping-item').toggleClass('is-open');
                })
                .on('change', '.js-recipe-checkbox', function () {
                    if($(this).prop('checked')){
                        $(this).closest('.j-shopping-item').addClass('is-checked');
                    } else {
                        $(this).closest('.j-shopping-item').removeClass('is-checked');
                    }
                })
                .on('click', '.js-select-recipe-button', function (event) {
                    event.preventDefault();
                    var $checkbox = $('.js-recipe-checkbox');
                    $checkbox.prop('checked', !$checkbox.is(':checked'));
                    $.each($checkbox, function() {
                        $(this).trigger('change');
                    });
                });
            }
        }

    Profile.init();

})(window.jQuery, window, document);