import {production} from './env'

export const resources = 'app/Resources/public/';
export const node_modules = 'node_modules/';
export const output = 'web/';

export const sass = {
    build: {
        base: `${resources}scss`,
        compilerOptions: {
            includePaths: [resources, node_modules],
            outputStyle: production ? 'compressed' : 'nested'
        },
        source: [
            `${resources}scss/app/**/*.scss`,
            `!**/import/**/*.scss`,
            `!**/import/*.scss`,
        ],
        destination: `${output}css/app.css`,
    },
    watch: `${resources}scss/**/*.scss`
};

/**
 * @see folder mapping via jspm's config file -> packages
 */
export const jspm = {
    application: {
        source: 'es6-shim + reflect-metadata + zone.js + ts-helpers + app',
        destination: `${output}js/build.js`,
    },
    tests: {
        source: 'app + [app-tests/**/*.ts] - [@angular/**/*.js]',
        destination: `${output}js/bundle-tests.js`
    }
};

export const ts = {
    project: `${resources}ts`
};
