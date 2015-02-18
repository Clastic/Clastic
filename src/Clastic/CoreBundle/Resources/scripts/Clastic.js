module.exports = function() {
    'use strict';
    global.Clastic = global.Clastic || {};

    /**
     * @class Clastic.Clastic
     * @constructor
     */
    global.Clastic.Clastic = function() {};

    global.Clastic.Clastic.prototype.resolvePaths = function(paths, rootDir) {
        var fs = require('fs');

        require('./GulpScript.js')();

        var extraScripts = [];
        fs.readdirSync(rootDir).forEach(function (file) {
            var pathDefinitions = rootDir + '/' + file + '/clastic.js';
            if (fs.existsSync(pathDefinitions) && !fs.statSync(pathDefinitions).isDirectory()) {
                extraScripts = extraScripts.concat(require(pathDefinitions)(paths));
            }
        });

        extraScripts.sort(function(a, b) {
            return (a.options.weight < b.options.weight) ? -1 : 1;
        });

        extraScripts.forEach(function(script) {
            paths.scripts[script.type] = paths.scripts[script.type] || [];
            paths.scripts[script.type].push(script.src);
        });

        return paths;
    };
};
