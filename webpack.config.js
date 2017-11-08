/**
 * This file is called by webpack's CLI for DEV and PROD, while TEST is imported by the karma webpack plugin.
 * It disables type checks and analytics for webpack config files and returns them as default exports.
 */
require('ts-node').register({
    fast: true, // no type checks
    project: './app/Resources/webpack'
});

module.exports = function webpackConfig(args) {
    return require('./app/Resources/webpack/webpack.' + args.env + '.ts').webpackConfig(args);
};
