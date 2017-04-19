/**
 * webpack --config does not support typescript, thus this compiling and module.export
 */
require('ts-node').register({
    fast: true, // no type checks
    project: './app/Resources/webpack' // use tsconfig.json for webpack config files
});

module.exports = function webpackConfig(args) {
    return require('./app/Resources/webpack/webpack.' + args.env + '.ts').webpackConfig(args);
};
