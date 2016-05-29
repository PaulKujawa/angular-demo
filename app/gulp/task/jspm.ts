import {production, verbose} from '../env';
import {jspm as config, output} from '../config';
import {ensureSymlink, Promise, readDir, remove} from '../fs';

const {join} = require('path');
const gulp = require('gulp');
const shell = require('gulp-shell');
const watch = require('gulp-watch');
const jspm = require('jspm');

class Vendor {
    constructor(public name: string, public path: string) {}
}

gulp.task('jspm:link', function() {
    const getVendors = (): Vendor[] => {
        const {map} = jspm.Loader();
        const vendors = Object.keys(map);

        return vendors.map((packageName: string): Vendor =>
            new Vendor(packageName, map[packageName].replace(/^(github|npm):/, `${output}jspm/packages/$1/`))
        );
    };

    const filterExistingSymlinks = (): any => {
        return readDir(config.symlink)
            .catch(error => [])
            .then(symlinkNames => Promise.all(symlinkNames
                .filter((name) => -1 === getVendors().map(vendor => vendor.name).indexOf(name))
                .map(name => remove(join(config.symlink, name)))
            ))
    };

    const createSymlink = (vendor: Vendor): PromiseLike<string> => {
        const symlink = config.symlink + '/' + vendor.name;

        return ensureSymlink(vendor.path, symlink).catch(error => {
            if (error.code === 'EEXIST') { // exists for different source (version)
                return remove(symlink).then(() => ensureSymlink(vendor.path, symlink));
            }
            return error;
        });
    };

    return filterExistingSymlinks().then(() => Promise.all(getVendors().map(createSymlink)));
});

gulp.task('jspm:build', ['ts:build', 'symfony:build'], function(gulp) {
    const {source, destination} = config.build;
    const command = [
        'node_modules/.bin/jspm ',
        'bundle',
        source,
        '- [angular2/src/**/*.js]',
        '- [angular2/platform/*.js]',
        '- [angular2/*.js]',
        destination,
        production ? '--no-mangle --skip-source-maps' : '--source-map-contents',
    ].join(' ');

    shell.task(command, {
        quiet: !verbose
    })(function(error) {
        if (error) {
            console.error(error.message);
            console.error(error.stderr);
        }
        gulp();
    });
});

gulp.task('jspm:watch', function() {
    return watch(config.watch, {verbose: true}, function() {
        gulp.start('jspm:build');
    });
});
