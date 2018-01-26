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
                    // write templates inline and transpile ts to js
                    test: /\.ts$/,
                    use: [
                        {
                            loader: 'awesome-typescript-loader',
                            options: {transpileOnly: true},
                        },
                        'angular2-template-loader',
                    ],
                }, {
                    // do not load (s)css
                    test: /\.scss$/,
                    loader: 'null-loader',
                }, {
                    // do not load images
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
