module.exports = function() {
    'use strict';
    return [
        new global.Clastic.GulpScript('web/vendor/jstree/dist/jstree.min.js', 'vendor', {weight: 10})
    ];
};
