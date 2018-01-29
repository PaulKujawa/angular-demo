import {Configuration} from 'webpack';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const merge = require('webpack-merge');

// Called by commonJs module karma.conf.js
export const webpackConfig = (args: WebpackArgs): Configuration => {
    const testConfig: Configuration = {
        devtool: 'inline-source-map', // used by karma-sourcemap-loader plugin
        module: {
            rules: [
                {
                    test: /\.ts$/,
                    loader: '@ngtools/webpack',
                }, {
                    test: /\.scss$/,
                    loader: 'null-loader',
                }, {
                    test: /\.(png|jpe?g|gif|svg|woff|woff2|ttf|eot|ico)$/,
                    loader: 'null-loader',
                },
            ],
        },
        plugins: [],
        resolve: {
            extensions: ['.ts', '.js'], // no .scss
        },
    };

    return merge(getCommonConfig(args), testConfig);
};
