import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {WebpackConfigArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const merge = require('webpack-merge');
const path = require('path');

// Called by commonJs module karma.conf.js
export const webpackConfig = (args: WebpackConfigArgs): Configuration => {
    const testConfig: Configuration = {
        devtool: 'inline-source-map', // used by karma-sourcemap-loader plugin
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
            new AngularCompilerPlugin({
                tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
                entryModule: path.resolve(__dirname, '../public/js/app/app.module#AppModule'),
            }),
        ],
    };

    return merge(getCommonConfig(args), testConfig);
};
