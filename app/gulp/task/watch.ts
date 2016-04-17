const gulp = require('gulp');
const sequence = require('gulp-sequence');

const watchTasks = sequence(
    [
        'sass:watch',
    ]
);

gulp.task('watch', watchTasks);
