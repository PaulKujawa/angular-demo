import {production} from '../env';

const gulp = require('gulp');
const sequence = require('gulp-sequence');
const shell = require('gulp-shell');
const params = production ? ' --no-debug --quiet --env=prod' : ' --no-debug --quiet';


gulp.task('symfony:routing', shell.task([
    'bin/console fos:js-routing:dump' + params,
]));

gulp.task('symfony:build', (gulp) => {
    // symfony's commands throw exception if called in parallel
    sequence(
        'symfony:routing'
    )(gulp);
});
