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

// no part of project's build process
gulp.task('angular:clear', (done) => {
    const {source} = config.application.angular;
    rimraf(`${source}/app-compiled`, done);
});
