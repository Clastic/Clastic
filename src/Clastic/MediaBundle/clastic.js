module.exports = function() {
    'use strict';
    return [
        new global.Clastic.GulpScript('web/assets/jquery-ui/jquery-ui.min.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/assets/elfinder/js/elfinder.min.js', 'vendor', {weight: 11})
    ];
};
