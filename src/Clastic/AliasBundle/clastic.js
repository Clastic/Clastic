module.exports = function() {
    'use strict';
    return [
        new global.Clastic.GulpScript('web/vendor/jquery-slugify/dist/slugify.min.js', 'vendor', {weight: 10})
    ];
};
