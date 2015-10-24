'use strict';

(function(){
    NProgress.start();

    var progress = window.setInterval(function() {
        NProgress.inc(0.1);
        console.log('loading');
    }, 250);

    $(window).on('load', function() {
        clearInterval(progress);
        NProgress.done();
    })
})();

