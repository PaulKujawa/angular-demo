import {sass as config} from '../config';
import {pipeIfDev} from '../env';

const concat = require('gulp-concat-util');
const sourcemaps = require('gulp-sourcemaps');
const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const watch = require('gulp-sane-watch');
const {basename, dirname} = require('path');

gulp.task('sass:build', () => {
    const {base, compilerOptions, source, destination} = config.build;

    return gulp.src(source, {base})
        .pipe(plumber())
        .pipe(pipeIfDev(() => sourcemaps.init()))
        .pipe(sass(compilerOptions).on('error', sass.logError))
        .pipe(concat(basename(destination), {
            process: (source: string): string => (source || '').trim()
        }))
        .pipe(pipeIfDev(() => sourcemaps.write('.')))
        .pipe(gulp.dest(dirname(destination)));
});

gulp.task('sass:watch', ['sass:build'], () => {
    return watch(config.watch, {debounce: 10}, () => {
        gulp.start('sass:build');
    })
});
