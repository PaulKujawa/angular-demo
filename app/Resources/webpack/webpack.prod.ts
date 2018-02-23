import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

export const webpackConfig = (args: WebpackArgs): Configuration => {
    const prodConfig: Configuration = {
        module: {
            rules: [
                {
                    test: /(?:\.ngfactory\.js|\.ngstyle\.js|\.ts)$/,
                    loader: '@ngtools/webpack',
                }, {
                    // transpile sass to css and load it as extra file separately
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract([
                        'css-loader',
                        'sass-loader',
                    ]),
                },
            ],
        },
        plugins: [
            new AngularCompilerPlugin({
                tsConfigPath: path.resolve(__dirname, '../public/js/tsconfig.json'),
                entryModule: path.resolve(__dirname, '../public/js/app/app.module#AppModule'),
            }),

            new BundleAnalyzerPlugin(),

            // based on output.path
            new ExtractTextPlugin(path.join('css/main.css')),

            // scope hoisting
            new webpack.optimize.ModuleConcatenationPlugin(),

            // stop the build if there is an error
            new webpack.NoEmitOnErrorsPlugin(),

            // minimizer
            new webpack.optimize.UglifyJsPlugin(),
        ],
    };

    return merge(getCommonConfig(args), prodConfig);
};
