import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const webpack = require('webpack');
const merge = require('webpack-merge');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

export const webpackConfig = (args: WebpackArgs): Configuration => {
    const prodConfig: Configuration = {
        // @ts-ignore
        mode: 'production',
        module: {
            rules: [
                {
                    test: /(?:\.ngfactory\.js|\.ngstyle\.js|\.ts)$/,
                    loader: '@ngtools/webpack',
                }, {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'sass-loader',
                    ],
                },
            ],
        },
        plugins: [
            new AngularCompilerPlugin({
                tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
                entryModule: path.resolve(__dirname, '../public/js/app/app.module#AppModule'),
            }),

            new BundleAnalyzerPlugin(),

            new MiniCssExtractPlugin({
                filename: 'css/main.[hash].css',
            }),

            new webpack.NoEmitOnErrorsPlugin(),
        ],
    };

    return merge(getCommonConfig(args), prodConfig);
};
