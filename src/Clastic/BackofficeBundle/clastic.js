module.exports = function() {
    'use strict';
    return [
        new global.Clastic.GulpScript('web/vendor/jquery/dist/jquery.min.js', 'vendor', {weight: 0}),
        new global.Clastic.GulpScript('web/vendor/bootstrap/dist/js/bootstrap.min.js', 'vendor', {weight: 0}),
        new global.Clastic.GulpScript('web/vendor/mousetrap/mousetrap.min.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/quicksearch/dist/jquery.quicksearch.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/multiselect/js/jquery.multi-select.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/select2/dist/js/select2.min.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/parsleyjs/dist/parsley.min.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/jstree/dist/jstree.min.js', 'vendor', {weight: 10}),
        new global.Clastic.GulpScript('web/vendor/nprogress/nprogress.js', 'vendor', {weight: 10})
    ];
};
