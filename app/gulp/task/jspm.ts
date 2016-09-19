import {production, watch} from '../env';
import {jspm as config} from '../config';
import {exec} from '../shell';

const gulp = require('gulp');

const jspm = (source: string, destination: string, globalName:string, build: boolean = true) => {
    const args = [
        build ? 'build' : 'bundle',
        source,
        destination,
        '--global-name ' + globalName,
    ];

    if (build) {
        args.push('--production');
    }

    if (watch) {
        args.push(
            '--skip-rollup',
            '--watch',
            '--log ok'
        );
    }

    if (production) {
        args.push(
            '--minify',
            '--skip-source-maps'
        );
    }

    return exec('jspm', args);
};

// build for dev & prod, resolves modules
let appBuildDeps = ['symfony:build'];
if (production) {
    process.env.ANGULAR_PRE_COMPILE = 'true';
    appBuildDeps.push('angular:build');
}

gulp.task('jspm:build:app', appBuildDeps, () => {
    let {source, destination, globalName} = config.application;

    if (production) {
        source = config.application.angular.bootstrap;
    }

    return jspm(source, destination, globalName);
});

gulp.task('jspm:build:vendor', ['symfony:build'], () => {
    const {source, destination, globalName} = config.vendor;

    return jspm(source, destination, globalName);
});

gulp.task('jspm:build', ['jspm:build:app', 'jspm:build:vendor']);

// for unit tests and still with module loader
gulp.task('jspm:test', ['symfony:build'], () => {
    const {source, destination, globalName} = config.tests;

    return jspm(source, destination, globalName, false);
});
