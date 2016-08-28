const gulp = require('gulp');
const sequence = require('gulp-sequence');

gulp.task('watch', sequence(
    [
        'sass:build',
        'symfony:build',
    ], [
        'ts:watch',
        'sass:watch',
        'jspm:build',
        'jspm:test',
    ]
));
