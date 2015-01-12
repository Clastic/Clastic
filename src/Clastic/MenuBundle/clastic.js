module.exports = function() {
    'use strict';
    return [
        new global.Clastic.GulpScript('web/vendor/jstree/dist/jstree5.min.js', 'vendor', {weight: 0}),
    ];
};
