const gulp = require('gulp');
const sequence = require('gulp-sequence');

const watchTasks = sequence([
    'build',
], [
    'ts:watch',
    'sass:watch',
    'jspm:watch',
    'jspm:bundle-test'
]);

gulp.task('watch', watchTasks);
