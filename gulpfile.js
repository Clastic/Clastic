var gulp = require('gulp');

// include plug-ins
var concat = require('gulp-concat'),
    stripDebug = require('gulp-strip-debug'),
    uglify = require('gulp-uglify'),
    autoprefix = require('gulp-autoprefixer'),
    minifyCSS = require('gulp-minify-css'),
    filesize = require('gulp-filesize'),
    rename = require('gulp-rename'),
    less = require('gulp-less'),
    cmq = require('gulp-combine-media-queries'),
    del = require('del'),
    livereload = require('gulp-livereload'),
    notify = require("gulp-notify"),
    clasticNamespace = require('./src/Clastic/CoreBundle/Resources/scripts/Clastic.js');

clasticNamespace();

var paths = {
    'styles': {
        'app': [
            'web/vendor/multiselect/css/multi-select.css',
            'src/Clastic/*/Resources/public/styles/**.less',
            'src/Clastic/*/Resources/public/styles/*/*.less'
        ],
        'main': 'src/Clastic/*/Resources/public/styles/style.less'
    },
    'scripts': {
        'vendor': [
            'src/Clastic/*/Resources/public/scripts/**.config.js',
            'http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js'
        ],
        'app': [
            'src/Clastic/*/Resources/public/scripts/**.js'
        ]
    },
    'templates': 'src/**/*.twig',
    'build': 'web/build/'
};

var clastic = new Clastic.Clastic();

var rootDir = __dirname + '/src/Clastic';
paths = clastic.resolvePaths(paths, rootDir);

var errorHandler = notify.onError(function (err) {
    return "Error: " + err.message;
});

gulp.task('default', ['clean', 'build', 'watch']);

gulp.task('clean', function (cb) {
    del([
        paths.build + '/**'
    ], cb);
});

gulp.task('build', ['scripts', 'styles']);

gulp.task('watch', function() {
    gulp.watch(paths.scripts.vendor, ['scripts:vendor']);
    gulp.watch(paths.scripts.app, ['scripts:app']);

    gulp.watch(paths.styles.vendor, ['styles:vendor']);
    gulp.watch(paths.styles.app, ['styles:app']);

    livereload.listen();
    gulp.watch([paths.build + '**', paths.templates])
        .on('change', livereload.changed);
});

gulp.task('scripts', ['scripts:vendor', 'scripts:app']);

gulp.task('scripts:vendor', function() {
    gulp.src(paths.scripts.vendor)
        .pipe(concat('vendor.js'))
        //.pipe(stripDebug())
        //.pipe(uglify())
        .pipe(rename('vendor.min.js'))
        .pipe(gulp.dest(paths.build))
        .pipe(filesize());
});

gulp.task('scripts:app', function() {
    gulp.src(paths.scripts.app)
        .pipe(concat('app.js'))
        //.pipe(stripDebug())
        //.pipe(uglify())
        .on('error', errorHandler)
        .pipe(rename('app.min.js'))
        .pipe(gulp.dest(paths.build))
        .pipe(filesize());
});

// CSS concat, auto-prefix and minify
gulp.task('styles', ['styles:app']);

gulp.task('styles:app', function() {
    gulp.src(paths.styles.main)
        .pipe(less())
        .on('error', errorHandler)
        .pipe(concat('app.css'))
        .pipe(autoprefix('last 2 versions'))
        .pipe(minifyCSS({
            keepSpecialComments: 0
        }))
        .pipe(rename('app.min.css'))
        .pipe(gulp.dest(paths.build))
        .pipe(filesize());
});
