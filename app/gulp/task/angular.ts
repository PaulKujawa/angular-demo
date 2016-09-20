import {watch} from '../env';
import {exec} from '../shell';
import {jspm as config} from '../config';

const gulp = require('gulp');
const rimraf = require('rimraf');
const gulpWatch = require('gulp-sane-watch');

const build = (): Promise => {
    const {source} = config.application.angular;

    return exec('ngc', ['--project', source], false);
};

gulp.task('angular:build', () => {
    process.env.ANGULAR_PRE_COMPILE = 'true';

    if (watch) {
        const {watchSource} = config.application.angular;
        gulpWatch(watchSource, {debounce: 200, verbose: false}, (filename) => {
            if (!/\.(ngfactory\.ts|js)$/.test(filename)) {
                build();
            }
        });
    }

    return build();
});

// not called automatically as it's no part of the build process
gulp.task('angular:clear', () => {
    const {source} = config.application.angular;

    rimraf.sync(`${source}/app/**/*.js`);
    rimraf.sync(`${source}/app/**/*.ngfactory.ts`);
    rimraf.sync(`${source}/node_modules`);
});
