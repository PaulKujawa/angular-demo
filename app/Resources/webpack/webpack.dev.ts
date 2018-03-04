import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

export const webpackConfig = (args: WebpackArgs): Configuration => {
    const devConfig: Configuration = {
        devtool: 'source-map',
        // @ts-ignore
        mode: 'development',
        module: {
            rules: [
                {
                    test: /\/public\/js\/.+\.ts$/,
                    enforce: 'pre',
                    use: {
                        loader: 'tslint-loader',
                        options: {
                            configFile: path.resolve(__dirname, '../public/js/tslint/main.json'),
                        },
                    },
                },
                {
                    test: /(?:\.ngfactory\.js|\.ngstyle\.js|\.ts)$/,
                    loader: '@ngtools/webpack',
                },
                {
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    sourceMap: true,
                                },
                            },
                            {
                                loader: 'sass-loader',
                                options: {
                                    sourceMap: true,
                                },
                            },
                        ],
                    }),
                },
            ],
        },
        plugins: [
            new AngularCompilerPlugin({
                tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
                entryModule: path.resolve(__dirname, '../public/js/app/app.module#AppModule'),
                sourceMap: true,
            }),

            new ExtractTextPlugin('css/main.[contenthash].css'),

            // @see https://github.com/angular/angular/issues/11580
            new webpack.ContextReplacementPlugin(
                /(.+)?angular(\\|\/)core(.+)?/,
                path.resolve(__dirname, '../public/js/app'),
            ),
        ],
    };

    return merge(getCommonConfig(args), devConfig);
};
