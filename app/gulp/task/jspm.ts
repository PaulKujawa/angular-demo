import {production, watch} from '../env';
import {jspm as config} from '../config';
import {exec} from '../shell';

const gulp = require('gulp');

const jspm = (source: string, destination: string, tests: boolean) => {
    const args = [
        tests ? 'bundle' : 'build --production',
        source,
        destination,
        '--source-map-contents'
    ];

    if (production) {
        args.push('--minify');
    }

    if (watch) {
        args.push('--skip-rollup --watch --log ok');
    }

    return exec('jspm', args);
};

gulp.task('jspm:build', ['symfony:build'], () => {
    const {source, destination} = config.application;

    return !watch && jspm(source, destination, false);
});

gulp.task('jspm:watch', () => {
    const {source, destination} = config.application;

    return jspm(source, destination, false);
});

gulp.task('jspm:bundle-test', ['symfony:build'], () => {
    const {source, destination} = config.tests;

    return jspm(source, destination, true);
});
