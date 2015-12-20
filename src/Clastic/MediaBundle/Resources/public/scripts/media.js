(function($) {
    $(function () {
        var $elfinder = $('.elfinder');

        $elfinder.each(function(i, elf){
            var homeFolder = '';
            var config = $(elf).data('elfinder');

            if (config.homeFolder) {
                homeFolder = '/' + config.homeFolder;
            }

            $elfinder.elfinder({
                url: '/admin/efconnect'+homeFolder,
                lang: 'en'
            });
        });
    });
})(jQuery);
