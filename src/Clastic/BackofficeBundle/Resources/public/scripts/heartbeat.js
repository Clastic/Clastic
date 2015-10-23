'use strict';

(function(){
    var tickUrl = '/admin/_heartbeat';

    $.ajax(tickUrl, {
        success: function (data) {
            setupHeartbeat(data.lifetime);
        }
    });

    var setupHeartbeat = function (timeout) {
        window.setInterval(function() {
            $.ajax(tickUrl);
        }, timeout * 900);
    };
})();
