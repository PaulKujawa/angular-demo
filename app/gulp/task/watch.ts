const gulp = require('gulp');
const sequence = require('gulp-sequence');

const watchTasks = sequence([
    'sass:watch',
    'ts:watch',
    'jspm:watch',
]);

gulp.task('watch', watchTasks);
