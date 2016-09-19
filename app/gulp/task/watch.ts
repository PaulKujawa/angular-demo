const gulp = require('gulp');
const sequence = require('gulp-sequence');

gulp.task('watch', sequence(
    [
        'sass:watch',
        'jspm:build',
        'jspm:test',
        'ts:watch',
    ]
));
