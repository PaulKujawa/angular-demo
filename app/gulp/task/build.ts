const gulp = require('gulp');
const sequence = require('gulp-sequence');

const tasks = sequence([
    'sass:build',
    'jspm:build',
    'symfony:build',
]);

gulp.task('build', tasks);
