(function() {
    $('textarea.wysiwyg').on('ckeditor-config', function(el, config) {
        config.filebrowserBrowseUrl = '/admin/elfinder/default';
    })
})();