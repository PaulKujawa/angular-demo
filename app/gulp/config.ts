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
        angular: {
            bootstrap: 'app/bootstrap-compiled',
            source: `${resources}ts`,
            watchSource: `${resources}ts/**/*.ts`,
        },
        source: 'app/bootstrap',
        destination: `${output}js/build.js`,
        globalName: 'appBundleExportBuild',
    },
    vendor: {
        source: 'vendor',
        destination: `${output}js/vendor.js`,
        globalName: 'appBundleExportVendor',
    }
};

export const symfony = {
    translations: {
        locales: ['en', 'de'],
        source: (locale: string): Array<string> => [
            `${output}bundles/bazingajstranslation/js/translator.min.js`,
            `${output}js/translations/config.js`,
            `${output}js/translations/**/${locale}.json`
        ],
        destination: (locale: string): string => `${output}js/translations.${locale}.js`,
        watch: 'app/Resources/translations/*.yml'
    }
};

export const ts = {
    project: `${resources}ts`,
};
