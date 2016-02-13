var gulp = require('gulp');
var sass = require('gulp-sass');
var clean = require('gulp-clean-dest');
var concat = require('gulp-concat');
var gulpif = require('gulp-if');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');

var source = 'app/Resources/public/scss/';
var output = 'web/css/';
var prod = false;

var sassOptions = {
    errLogToConsole: true,
    outputStyle: prod ? 'compressed' : 'nested'
};

var completeSource = [
    source + 'app/**/*.scss',
    '!**/import/**/*.scss',
    'web/vendor/angular-chart.js/dist/angular-chart.css',
    'web/vendor/angular-ui-tree/dist/angular-ui-tree.min.css'
];

gulp.task('sass', function () {
    return gulp.src(completeSource)
        .pipe(plumber())
        .pipe(gulpif(/[.]scss$/, sass(sassOptions).on('error', sass.logError)))
        .pipe(clean(output))
        .pipe(concat('app.css'))
        .pipe(gulp.dest(output));
});

gulp.task('default', function () {
    return gulp.watch(source + '**/*.scss', ['sass']);
});
