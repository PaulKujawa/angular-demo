const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
import {commonConfig} from './webpack.common';

export function webpackConfig(args: Object) {
    const env = process.env.ENV = process.env.NODE_ENV;

    return merge(commonConfig({env: env}), {
        devServer: {
            historyApiFallback: true,
            watchOptions: {
                aggregateTimeout: 300,
                poll: 1000
            }
        },
        devtool: 'cheap-module-eval-source-map',
        module: {
            rules: [
                {
                    // write templates inline and transpile ts to js
                    test: /\.ts$/, loaders: ['awesome-typescript-loader', 'angular2-template-loader']
                }, {
                    // transpile sass to css and load it inline
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({use: [{loader: 'css-loader'}, {loader: 'sass-loader'}]})
                    //loader: ['style-loader', 'css-loader', 'sass-loader'] TODO use this instead for HRM
                },
            ]
        },
        plugins: [
            // live chunk replacement via webpack's dev-server
            new webpack.HotModuleReplacementPlugin(),

            // generate separate css file to load see to do above
            new ExtractTextPlugin('web/css/main.css'),
        ]
    });
}
