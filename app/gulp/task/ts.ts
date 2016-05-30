import {ts as config} from '../config';
import compile = require('gulp-typescript/release/main');
import Settings = compile.Settings;
import {pipeIfDev} from '../env';
import {Promise, remove} from '../fs';

const gulp = require('gulp');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');
const ts = require('gulp-typescript');
const watch = require('gulp-watch');
const {join} = require('path');

const build = function (source: string|string[], destination: string, base: string, project: any) {
    return gulp.src(source, {base})
        .pipe(plumber())
        .pipe(pipeIfDev(() => sourcemaps.init()))
            .pipe(ts(project))
        .pipe(pipeIfDev(() => sourcemaps.write('./maps')))
        .pipe(gulp.dest(destination));
};

const createProject = function (compilerOptions: Settings, compilerOptionOverrides: Settings = {}): any {
    const options: Settings = {};
    Object.keys(compilerOptions).forEach(function (key) {
        options[key] = compilerOptionOverrides[key] || compilerOptions[key];
    });

    return ts.createProject(options);
};

gulp.task('ts:clean', function() {
    return Promise.all(config.clean.map(path => remove(path)));
});

gulp.task('ts:build', ['ts:clean', 'jspm:link'], function () {
    const {base, compilerOptions, destination, source, typingDefinition} = config.build;
    const project = createProject(compilerOptions);

    return build([typingDefinition].concat(source), destination, base, project);
});

gulp.task('ts:lint', function() {
    // (slowly) compile whole project to be sure everything sticks together
    const {source, base, compilerOptions, typingDefinition} = config.build;
    const lintProject = createProject(compilerOptions);

    return gulp.src([typingDefinition].concat(source), {base})
        .pipe(plumber())
        .pipe(ts(lintProject));
});

gulp.task('ts:watch', function() {
    const {base, compilerOptions, destination, typingDefinition} = config.build;

    return watch(config.watch, {verbose: true}, function(vinyl) {
        if (vinyl.event == 'unlink') {
            return remove(join(destination, vinyl.relative.replace(/\.ts$/, '.js')));
        }
        gulp.start('ts:lint');
        const project = createProject(compilerOptions, {isolatedModules: true});

        return build([typingDefinition, vinyl.path], destination, base, project); // quickly compile modified file
    });
});
