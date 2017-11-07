// load webpack test config for karma-webpack plugin
var webpackConfig = require('./app/Resources/webpack/webpack.test').webpackConfig({env: 'test'});

// expunge symfony based JS exports to be able to run JS unit tests w/o backend bundling
var NormalModuleReplacementPlugin = require('webpack').NormalModuleReplacementPlugin;
var moduleReplacementPlugin = new NormalModuleReplacementPlugin(/web\/(js|bundles)\//, 'tests/karma/empty');
webpackConfig.plugins.push(moduleReplacementPlugin);

module.exports = (config) => {
    config.set({
        beforeMiddleware: [
            'webpackBlocker', // see karma-sourcemap-loader
        ],
        browserNoActivityTimeout: 60000,
        browsers: [
            'ChromeHeadless',
        ],
        files: [
            // TODO clarify: override autowatch: true since karma-webpack does that or due to conflicts with IDE
            {pattern: 'app/Resources/public/js/tests/karma/test-main.js', watched: false},
        ],
        frameworks: [
            'jasmine',
        ],
        plugins: [
            'karma-chrome-launcher',
            'karma-webpack',
            'karma-sourcemap-loader',
            'karma-jasmine',
            'karma-mocha-reporter',
        ],
        preprocessors: {
            'app/Resources/public/js/tests/karma/test-main.js': ['webpack', 'sourcemap'], // see karma-sourcemap-loader
        },
        reporters: [
            'mocha',
        ],
        webpack: webpackConfig,
        webpackMiddleware: {noInfo: true, stats: 'errors-only'}, // see karma-sourcemap-loader
    });
};
