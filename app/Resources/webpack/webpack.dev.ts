import {WebpackArgs} from './webpack-args';
import {commonConfig} from './webpack.common';
const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

export function webpackConfig(args: WebpackArgs) {
    const rootPath = path.join(__dirname, '../../../');
    const cachePath = path.join(rootPath, 'var/cache/dev/webpack');

    return merge(commonConfig(args), {
        devServer: {
            historyApiFallback: true,
            watchOptions: {
                aggregateTimeout: 300,
                poll: 1000,
            },
        },
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\/public\/js\/.+\.ts$/,
                    enforce: 'pre',
                    use: 'tslint-loader',
                }, {
                    // write templates inline and transpile ts to js
                    test: /\.ts$/,
                    use: [
                        {loader: 'cache-loader', options: {cacheDirectory: cachePath + '/js'}},
                        'awesome-typescript-loader',
                        'angular2-template-loader',
                        'angular-router-loader',
                    ],
                }, {
                    // transpile sass to css and load it inline
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({ // TODO remove this line for HMR
                        use: [
                            {loader: 'cache-loader', options: {cacheDirectory: cachePath + '/css'}},
                            // {loader: "style-loader"}, TODO add this line for HMR
                            {loader: 'css-loader', options: {sourceMap: true}},
                            {loader: 'sass-loader', options: {sourceMap: true}},
                        ],
                    }),
                },
            ],
        },
        plugins: [
            // live chunk replacement via webpack's dev-server
            //  new webpack.HotModuleReplacementPlugin(), TODO HMR

            // generate separate css file to load see to do above, based on output.path
            new ExtractTextPlugin('css/main.css'),
        ],
    });
}
