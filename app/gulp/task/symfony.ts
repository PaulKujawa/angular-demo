import {production} from "../env";

const gulp = require('gulp');
const shell = require('gulp-shell');

const params = production
    ? ' --no-debug --quiet --env=prod'
    : ' --no-debug --quiet';


gulp.task('symfony:routing', shell.task([
    'bin/console fos:js-routing:dump' + params,
]));
