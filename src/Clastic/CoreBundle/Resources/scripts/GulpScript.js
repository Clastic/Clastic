module.exports = function() {
    'use strict';
    global.Clastic = global.Clastic || {};
    var Clastic = global.Clastic;

    Clastic.GulpScript = function(src, type, options) {
        this.src = src;
        this.type = type;
        this.options = _.extend(this.getDefaultOptions(), options);
    };

    Clastic.GulpScript.prototype.getDefaultOptions = function() {
        return {
            'weight': 0
        };
    };
};
