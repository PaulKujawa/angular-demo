import {production} from './env'

export const resources = 'app/Resources/public/';
export const output = 'web/';

export const sass = {
    build: {
        // construct destination tree from 'scss/'
        base: `${resources}scss`,
        compilerOptions: {
            includePaths: [resources],
            outputStyle: production ? 'compressed' : 'nested'
        },
        destination: `${output}css`,
        source: [
            `${resources}scss/app/**/*.scss`,
            `!**/import/**/*.scss`,
            `!**/import/*.scss`,
        ],
    },
    clean: `${output}css`,
    concat: {
        destination: `${output}css/app.css`,
        source: [
            `${output}css/app__main.css`,
            `${output}css/app__*.css`,
        ],
    },
    watch: `${resources}scss/**/*.scss`
};

export const jspm = {
    build: {
        source: production ? `js/app/bootstrap` : `js/app/vendor`,
        destination: `${output}jspm/build.js`
    },
    symlink: `${resources}node_modules`,
    watch: `${resources}ts/app/vendor.ts`
};

export const ts = {
    build: {
        base: `${resources}ts`,
        compilerOptions: {
            module: 'commonjs',
            target: 'ES5',
            moduleResolution: 'node',
            emitDecoratorMetadata: true,
            experimentalDecorators: true,
            removeComments: true,
            noImplicitAny: false,
            noEmitOnError: false,
            noExternalResolve: false,
            isolatedModules: false,
            typescript: require('typescript')
        },
        destination: `${output}js`,
        source: [
            `${resources}ts/app/**/*.ts`,
            `${resources}ts/tests/**/*.ts`,
        ],
        typingDefinition: 'typings/main.d.ts'
    },
    clean: [
        `${output}js/?(application|tests|maps)/**/*.?(js|map)`,
        `${output}js/?(application|tests|maps)/*.?(js|map)`
    ],
    watch: [
        `${resources}ts/**/*.ts`,
        `!**/vendor.ts` // watched by jspm:watch
    ]
};
