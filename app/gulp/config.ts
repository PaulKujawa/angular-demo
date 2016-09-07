import {production} from './env'

export const resources = 'app/Resources/public/';
export const node_modules = 'node_modules/';
export const output = 'web/';

export const sass = {
    build: {
        base: `${resources}scss`,
        compilerOptions: {
            includePaths: [resources, node_modules],
            outputStyle: production ? 'compressed' : 'nested',
        },
        source: [
            `${resources}scss/app/**/*.scss`,
            `!**/import/**/*.scss`,
            `!**/import/*.scss`,
        ],
        destination: `${output}css/app.css`,
    },
    watch: `${resources}scss/**/*.scss`,
};

export const jspm = {
    application: {
        source: 'app/bootstrap',
        sourceAngularCompile: 'app/bootstrap-precompiled',
        destination: `${output}js/build.js`,
        globalName: 'baBundleExportBuild',
    },
    tests: {
        source: 'app/bootstrap + [app-tests/**/*.ts]',
        destination: `${output}js/bundle-tests.js`,
        globalName: 'baBundleExportTests',
    },
    vendor: {
        source: 'vendor',
        destination: `${output}js/vendor.js`,
        globalName: 'baBundleExportVendor',
    }
};

export const ts = {
    project: `${resources}ts`,
};
