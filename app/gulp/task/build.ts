const gulp = require('gulp');
const sequence = require('gulp-sequence');

const tasks = sequence(['sass:clean'], [
    'sass:concat',
    'symfony:build',
    'ts:build',
    'jspm:build',
]);

gulp.task('build', tasks);
