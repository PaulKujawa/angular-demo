import {production, watch} from '../env';
import {jspm as config} from '../config';
import {exec} from '../shell';

const gulp = require('gulp');

const jspm = (source: string, destination: string, globalName:string) => {
    const args = [
        'build',
        source,
        destination,
        '--global-name ' + globalName,
        '--production',
    ];

    if (watch) {
        args.push(
            '--skip-rollup',
            '--watch',
            '--log ok'
        );
    }

    if (production) {
        args.push('--minify', '--skip-source-maps');
    } else {
        args.push('--source-map-contents')
    }

    return exec('jspm', args);
};

let appBuildDeps = ['symfony:build'];
if (production) {appBuildDeps.push('angular:build')}
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
