const gulp = require('gulp');
const sequence = require('gulp-sequence');

gulp.task('watch', sequence(
    [
        'sass:watch',
        'jspm:build',
        'ts:watch',
        'symfony:translation:watch'
    ]
));
