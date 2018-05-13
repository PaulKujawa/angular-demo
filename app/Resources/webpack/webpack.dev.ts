import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {getCommonConfig} from './webpack.common';
const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

export const webpackConfig = (): Configuration => {
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
                    use: [
                        MiniCssExtractPlugin.loader,
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true,
                            },
                        },
                        // TODO use postcss-loader for autoprefixer
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true,
                            },
                        },
                    ],
                },
            ],
        },
        plugins: [
            new AngularCompilerPlugin({
                tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
                entryModule: path.resolve(__dirname, '../public/js/app/app.module#AppModule'),
                sourceMap: true,
            }),

            new MiniCssExtractPlugin({
                filename: 'css/main.[hash].css',
            }),

            // @see https://github.com/angular/angular/issues/11580
            new webpack.ContextReplacementPlugin(
                /(.+)?angular(\\|\/)core(.+)?/,
                path.resolve(__dirname, '../public/js/app'),
            ),
        ],
    };

    return merge(getCommonConfig(), devConfig);
};
