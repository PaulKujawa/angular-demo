module.exports = function(config) {
    config.set({
        basePath: '',
        autoWatch: true,
        singleRun: false,
        concurrency: Infinity,
        logLevel: config.LOG_INFO,
        port: 9876, // web server
        colors: true,

        browsers: ['PhantomJS'],
        frameworks: ['jasmine'],
        reporters: ['spec'],
        middleware: ['node-modules'], // for node_modules modules imported with requireJs

        files: [
            // system.js
            'web/jspm/packages/system.js',
            'web/jspm/config-test.js', // normally part of karma-test-shim, but baseURL needs to be defined initially
            'web/jspm/config.js',

            // vendors (incl. zone) + zone test modules
            'web/js/vendor.js',
            'node_modules/zone.js/dist/long-stack-trace-zone.js',
            'node_modules/zone.js/dist/proxy.js',
            'node_modules/zone.js/dist/sync-test.js',
            'node_modules/zone.js/dist/jasmine-patch.js',
            'node_modules/zone.js/dist/async-test.js',
            'node_modules/zone.js/dist/fake-async-test.js',

            // jspm
            {pattern: 'web/jspm/**/*.js', included: false, watched: false},
            {pattern: 'web/jspm/**/*.json', included: false, watched: false},
            {pattern: 'web/jspm/**/*.js.map', included: false, watched: false},

            // app
            {pattern: 'app/Resources/public/ts/**/*.ts', included: false, watched: true},

            // start tests from
            'app/Resources/public/ts/tests/karma-test-shim.js'
        ],

        preprocessors: {
            'app/Resources/public/ts/app/**/*.ts': ['typescript'],
            'app/Resources/public/ts/tests/**/*.ts': ['typescript'],
            '**/*': ['sourcemap']
        },
        typescriptPreprocessor: {
            options: {
                inlineSourceMap: true,
                inlineSources: true,
                module: "system",
                target: "es5",
                moduleResolution: "node",
                emitDecoratorMetadata: true,
                noEmitHelpers: true,
                experimentalDecorators: true,
                rootDir: "."
            },
            transformPath: function(path) {
                return path.replace(/\.ts$/, '.js');
            }
        }
    })
};
