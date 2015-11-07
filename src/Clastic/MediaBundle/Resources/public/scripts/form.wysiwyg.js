'use strict';

(function($) {
    $('textarea.wysiwyg').on('ckeditor-config', function(el, config) {
        config.filebrowserBrowseUrl = '/admin/elfinder/default';
    });

    $('.file_browser_container').each(function() {
        var $container = $(this);
        var $el = $container.find('input');
        var $finder = $container.find('.finder');
        var $img = $container.find('img.preview');
        var $imgCaption = $container.find('.caption');

        var sync = function() {
            var val = $el.val();
            $img.attr('src', val);
            if (!$img.attr('src')) {
                $img.hide();
            } else {
                $img.show();
            }
            $imgCaption.html(val);
        };
        var setValue = function(val) {
            $el.val(val);
            sync();
        };

        sync();

        $container
            .on('click', 'button.select', function() {
                if ($finder.hasClass('elfinder')) {
                    $finder.elfinder('open');
                } else {
                    $finder
                        .elfinder({
                            url : '/admin/efconnect',
                            getFileCallback: function(file) {
                                setValue('/'+file.path);
                                sync();
                                $finder.elfinder('close');
                            }
                        })
                        .elfinder($el.attr('id'));
                }
            })
            .on('click', 'button.unselect', function() {
                setValue('');
                sync();
            })
    });
})(jQuery);
