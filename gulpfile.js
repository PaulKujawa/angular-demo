var gulp = require('gulp');
var sass = require('gulp-sass');
var clean = require('gulp-clean-dest');
var concat = require('gulp-concat');
var gulpif = require('gulp-if');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');
var ts = require('gulp-typescript');

var source = 'app/Resources/public/';
var prod = false;

var sourceSass = [
    source + 'scss/app/**/*.scss',
    '!**/import/**/*.scss',
    'web/vendor/angular-chart.js/dist/angular-chart.css',
    'web/vendor/angular-ui-tree/dist/angular-ui-tree.min.css'
];

gulp.task('sass', function () {
    return gulp.src(sourceSass)
        .pipe(plumber())
        .pipe(gulpif(/[.]scss$/, sass({
            errLogToConsole: true,
            outputStyle: prod ? 'compressed' : 'nested'
        }).on('error', sass.logError)))
        .pipe(clean('web/css/'))
        .pipe(concat('app.css'))
        .pipe(gulp.dest('web/css/'));
});

// see https://github.com/ivogabe/gulp-typescript#options
gulp.task('ts', function () {
    return gulp.src(source + 'js/**/*.ts')
        .pipe(ts({
            target: 'ES5',
            module: 'system',
            moduleResolution: 'node',
            emitDecoratorMetadata: true,
            experimentalDecorators: true,
            removeComments: false,
            noImplicitAny: false,
            out: 'app.js'
        }))
        .pipe(clean('web/ts/'))
        .pipe(gulp.dest('web/js/'))
});
