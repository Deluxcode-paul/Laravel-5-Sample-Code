tinymce.init({
    selector: "textarea.tinymce",
    skin: "dick-light",
    plugins: "image,link,media,anchor,paste",
    file_browser_callback: article_elFinderBrowser,
    menubar: false,
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    paste_as_text: true
});

function article_elFinderBrowser(field_name, url, type, win) {
    tinymce.activeEditor.windowManager.open({
        file: backpack.tinymceBrowseUrl,
        title: 'elFinder 2.0',
        width: 900,
        height: 450,
        resizable: 'yes'
    }, {
        setUrl: function (url) {
            win.document.getElementById(field_name).value = url;
        }
    });

    return false;
}
