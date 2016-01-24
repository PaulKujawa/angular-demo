var gulp = require('gulp');
gulp.task('default', function () {});

var sass = sass = require('gulp-sass');
gulp.task('sass', function () {
    gulp.src('./web/scss/*.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(gulp.dest('./web/css/'));
});