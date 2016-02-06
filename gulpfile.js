var gulp = require('gulp');
var sass = require('gulp-sass');
var source = 'app/Resources/public/scss/**/*.scss';
var output = 'web/css/';

gulp.task('sass', function () {
    return gulp.src(source)
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(gulp.dest(output));
});

gulp.task('default', function() {
   gulp.watch(source, ['sass']);
});