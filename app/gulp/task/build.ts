const gulp = require('gulp');
const sequence = require('gulp-sequence');

gulp.task('build', sequence(
    [
        'sass:build',
        'jspm:build',
        'symfony:build',
    ]
));
