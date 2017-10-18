jQuery(document).ready(function ($) {
    $('textarea.ckeditor').ckeditor({
        "filebrowserBrowseUrl": backpack.ckeditorBrowseUrl,
        "extraPlugins": 'oembed,widget'
    });
});