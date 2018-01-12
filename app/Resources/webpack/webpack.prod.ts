import {AngularCompilerPlugin} from '@ngtools/webpack';
import {Configuration} from 'webpack';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');

export const webpackConfig = (args: WebpackArgs): Configuration => {
    const rootPath = path.join(__dirname, '../../..');
    const jsPath = path.join(rootPath, 'app/Resources/public/js');

    const prodConfig: Configuration = {
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.ts$/,
                    loader: '@ngtools/webpack',
                }, {
                    // transpile sass to css and load it as extra file separately
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({
                        use: [
                            {
                                loader: 'css-loader',
                                options: {sourceMap: true},
                            },
                            {
                                loader: 'sass-loader',
                                options: {sourceMap: true},
                            },
                        ],
                    }),
                },
            ],
        },
        plugins: [
            new AngularCompilerPlugin({
                tsConfigPath: path.join(jsPath, 'tsconfig.json'),
                entryModule: path.join(jsPath, 'app/app.module#AppModule'),
            }),

            // generate separate css file to load, based on output.path
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
