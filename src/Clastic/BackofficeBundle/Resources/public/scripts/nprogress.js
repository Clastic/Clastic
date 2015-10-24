'use strict';

(function(){
    NProgress.start();

    var progress = window.setInterval(function() {
        NProgress.inc(0.1);
    }, 250);

    $(window).load(function() {
        clearInterval(progress);
        NProgress.done();
    });
})();

