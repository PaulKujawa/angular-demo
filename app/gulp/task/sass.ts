import {sass as config} from '../config';
import {remove} from "../fs";
import {pipeIfDev, production} from "../env";

const concat = require('gulp-concat-util');
const foreach = require('gulp-foreach');
const sourcemaps = require('gulp-sourcemaps');
const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sass = require('gulp-sass');
const watch = require('gulp-watch');
const {basename, dirname, join} = require('path');

const flattenDirectories = (file:string):string => file.replace(/\//g, '__');

const build = function(source, destination) {
    const {base, compilerOptions} = config.build;

    return gulp.src(source, {base})
        .pipe(plumber())
        .pipe(pipeIfDev(function() {
            return sourcemaps.init();
        }))
            .pipe(sass(compilerOptions).on('error', sass.logError))
            .pipe(foreach(function(stream, file) {
                file.path = join(file.base, flattenDirectories(file.relative));
                return stream;
            }))
        .pipe(pipeIfDev(function() {
            return sourcemaps.write('./maps');
        }))
        .pipe(gulp.dest(destination));
};

gulp.task('sass:clean', function() {
    return remove(config.clean);
});

gulp.task('sass:build', function() {// todo ['jspm:link']
    const {source, destination} = config.build;

    return build(source, destination);
});

gulp.task('sass:concat', ['sass:build'], function() {
    const {source, destination} = config.concat;

    return gulp.src(source)
        .pipe(plumber())
        /*  you will find a bunch of compiled css files in dev *and* prod
            remember this is a stream -> original css files won't be modified/replace

            the concat command below will merge these file's content into one destination file (e.g. app.css)
            prod = all the css content is merged into one single file -> other files being ignored!
            dev = replaces the content in every file with an import of itself -> other files being imported!
         */
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
        const isAddedOrRemovedFile = vinyl.event == 'add' || vinyl.event == 'unlink';

        if (isImport || isAddedOrRemovedFile) {
            gulp.start('sass:concat');
            return;
        }

        return build(vinyl.path, destination);
    });
});
