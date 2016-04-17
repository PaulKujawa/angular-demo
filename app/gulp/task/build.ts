const gulp = require('gulp');
const sequence = require('gulp-sequence');

const tasks = sequence(
    [
        'sass:clean',
    ],
    [
        'sass:concat',
    ]
);

gulp.task('build', tasks);
