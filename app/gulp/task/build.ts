const gulp = require('gulp');
const sequence = require('gulp-sequence');

const tasks = sequence(
    [
        'sass:clean',
    ],
    [
        'sass:concat',
        'symfony:routing',
    ]
);

gulp.task('build', tasks);
