/**
 * webpack --config does not support typescript, thus this compiling and module.export
 */
require('ts-node').register({
    fast: true, // no type checks
    project: './app/Resources/webpack' // use tsconfig.json for webpack config files
});

if (['dev', 'test', 'prod'].indexOf(process.env.NODE_ENV) === -1) {
    console.error('ERROR: node_modules/.bin/webpack needs to be run with NODE_ENV being either dev, test or prod.');

    // As no config-env is chosen, the calling webpack process must be terminated
    process.exit();
}

module.exports = require('./app/Resources/webpack/webpack.' + process.env.NODE_ENV + '.ts').webpackConfig;
