(function() {
    'use strict';

    $(function() {
        var $elements = $('textarea.wysiwyg');
        if (!$elements.length) {
            return;
        }

        $.ajax({
            url: "/vendor/ckeditor/ckeditor.js",
            dataType: "script",
            cache: true
        }).done(function() {
            $.ajax({
                url: "/vendor/ckeditor/adapters/jquery.js",
                dataType: "script",
                cache: true
            }).done(function() {
                $elements.ckeditor();
            });
        });
    });
}());
