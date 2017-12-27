import {Configuration} from 'webpack';
import {WebpackArgs} from './webpack-args';
import {getCommonConfig} from './webpack.common';
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');
const {AngularCompilerPlugin} = require('@ngtools/webpack');

export const webpackConfig = (args: WebpackArgs): Configuration => {
    const rootPath = path.join(__dirname, '../../..');
    const jsPath = path.join(rootPath, 'app/Resources/public/js');
    const cachePath = path.join(rootPath, 'var/cache/prod/webpack');

    const prodConfig: Configuration = {
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.ts$/,
                    use: [
                        {loader: 'cache-loader', options: {cacheDirectory: `${cachePath}/js`}},
                        '@ngtools/webpack',
                    ],
                }, {
                    // transpile sass to css and load it as extra file separately
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({
                        use: [
                            {loader: 'cache-loader', options: {cacheDirectory: cachePath + '/css'}},
                            {loader: 'css-loader', options: {sourceMap: true}},
                            {loader: 'sass-loader', options: {sourceMap: true}},
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
            new ExtractTextPlugin('css/main.css'),

            // stop the build if there is an error
            new webpack.NoEmitOnErrorsPlugin(),

            // minimizer
            new webpack.optimize.UglifyJsPlugin(),
        ],
    };

    return merge(getCommonConfig(args), prodConfig);
};
