(function($) {
    $(function () {
        var $elfinder = $('.elfinder');

        if ($elfinder.length) {
            $elfinder.elfinder({
                url: '/admin/efconnect',
                lang: 'en'
            });
        }
    });
})(jQuery);