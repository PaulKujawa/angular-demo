import {ts as config} from '../config';
import {exec} from "../shell";
import {watch} from "../env";

const gulp = require('gulp');

gulp.task('ts:lint', () => {
    const args = [config.project, '--noEmit --pretty --project'];

    if (watch) {
        args.push('--watch');
    }

    return exec('tsc', args);
});

gulp.task('ts:watch', () => {
    gulp.start('ts:lint');
});
