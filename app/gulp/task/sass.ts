import {sass as config} from '../config';
import {remove} from '../fs';
import {pipeIfDev} from '../env';

const concat = require('gulp-concat-util');
const foreach = require('gulp-foreach');
const sourcemaps = require('gulp-sourcemaps');
const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const watch = require('gulp-watch');
const {basename, dirname, join} = require('path');

const build = function(source: string|string[], destination: string|string[]) {
    const {base, compilerOptions} = config.build;
    const flattenDirectories = (file: string): string => file.replace(/\//g, '__');

    return gulp.src(source, {base})
        .pipe(plumber())
        .pipe(pipeIfDev(() => sourcemaps.init()))
            .pipe(sass(compilerOptions).on('error', sass.logError))
            .pipe(foreach(function(stream, file) {
                file.path = join(file.base, flattenDirectories(file.relative));

                return stream;
            }))
        .pipe(pipeIfDev(() => sourcemaps.write('./maps')))
        .pipe(gulp.dest(destination));
};

gulp.task('sass:clean', function() {
    return remove(config.clean);
});

gulp.task('sass:build', ['jspm:link'], function() {// todo
    const {source, destination} = config.build;

    return build(source, destination);
});

gulp.task('sass:concat', ['sass:build'], function() {
    /*  you will find a bunch of compiled css files in dev *and* prod
     remember this is a stream -> original css files won't be modified/replaced

     prod = all the css content is merged into one single file -> other files neither used nor removed!
     dev = replaces the content in every file with an import of itself -> other files being imported!
     */
    const {source, destination} = config.concat;

    return gulp.src(source)
        .pipe(plumber())
        .pipe(pipeIfDev(function() {
            return foreach(function(stream, file) {
                file.contents = new Buffer(`@import '${file.relative}';`);

                return stream;
            })
        }))
        .pipe(concat(basename(destination)))
        .pipe(gulp.dest(dirname(destination)));
});

gulp.task('sass:watch', function() {
    const {destination} = config.build;

    return watch(config.watch, {verbose: true}, function(vinyl) {
        const isImport = /import\//.test(vinyl.relative);

        if (isImport || vinyl.event == 'add' || vinyl.event == 'unlink') {
            gulp.start('sass:concat');

            return;
        }

        return build(vinyl.path, destination);
    });
});
