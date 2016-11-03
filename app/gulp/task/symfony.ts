import {production} from '../env';
import {symfony as config} from '../config';

const {basename, dirname} = require('path');
const concat = require('gulp-concat-util');
const foreach = require('gulp-foreach');
const gulp = require('gulp');
const mergeStream = require('merge-stream');
const plumber = require('gulp-plumber');
const sequence = require('gulp-sequence');
const shell = require('gulp-shell');
const watch = require('gulp-sane-watch');
const symfonyArgs = production ? ' --env=prod' : '';

gulp.task('symfony:routing', shell.task([
    'bin/console fos:js-routing:dump --no-debug' + symfonyArgs
]));

gulp.task('symfony:translation:dump', shell.task([
    'bin/console bazinga:js-translation:dump' + symfonyArgs
]));

gulp.task('symfony:translation', ['symfony:translation:dump'], () => {
    // config files are not AMD ready, thus systemJs is no option
    const concatTranslation = (source: Array<string>, destination: string) => {
        return gulp.src(source)
            .pipe(plumber())
            .pipe(foreach((stream, file) => {
                if (/\.json$/.test(file.relative)) {
                    const json = (file.contents.toString('utf8') || '{}').trim();
                    file.contents = new Buffer(`Translator.fromJSON(${json});`);
                }
                return stream;
            }))
            .pipe(concat(basename(destination)))
            .pipe(gulp.dest(dirname(destination)));
    };

    const {locales, source, destination} = config.translations;
    const translations = locales.map((locale: string) => concatTranslation(source(locale), destination(locale)));

    return mergeStream(...translations);
});

gulp.task('symfony:build', (gulp) => {
    // symfony's commands throw an exception if called in parallel
    sequence(
        'symfony:translation',
        'symfony:routing'
    )(gulp);
});

gulp.task('symfony:translation:watch', () => {
    return watch(config.translations.watch, {debounce: 10}, () => {
        gulp.start('symfony:translation')
    });
});