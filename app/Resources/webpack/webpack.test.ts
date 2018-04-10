import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {WebpackConfigArgs} from './webpack-args';
const path = require('path');

// Called by commonJs module karma.conf.js
export const webpackConfig = (args: WebpackConfigArgs): Configuration => ({
    devtool: 'inline-source-map', // used by karma-sourcemap-loader plugin
    // @ts-ignore
    mode: 'development',
    module: {
        rules: [
            {
                test: /(?:\.ngfactory\.js|\.ngstyle\.js|\.ts)$/,
                loader: '@ngtools/webpack',
            },
            {
                test: /\.scss$/,
                loader: 'null-loader',
            }, {
                test: /\.(png|jpe?g|gif|svg|woff|woff2|ttf|eot|ico)$/,
                loader: 'null-loader',
            },
        ],
    },
    plugins: [
        // TODO check if ProvidePlugin is required for tests

        new AngularCompilerPlugin({
            tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
            skipCodeGeneration: true,
        }),
    ],
    resolve: {
        extensions: ['.ts', '.js'],
    },
});
