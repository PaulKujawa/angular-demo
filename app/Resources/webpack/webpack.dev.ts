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
        devtool: 'source-map',
        module: {
            rules: [
                {
                    // write templates inline and transpile ts to js
                    test: /\.ts$/, loaders: ['awesome-typescript-loader', 'angular2-template-loader']
                }, {
                    // transpile sass to css and load it inline
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({ // TODO remove this line for HMR
                        use: [
                            //{loader: "style-loader"}, TODO add this line for HMR
                            {loader: 'css-loader', options: {sourceMap: true }},
                            {loader: 'sass-loader', options: {sourceMap: true }}
                        ]
                    })
                },
            ]
        },
        plugins: [
            // live chunk replacement via webpack's dev-server
            //  new webpack.HotModuleReplacementPlugin(), TODO HMR

            // generate separate css file to load see to do above
            new ExtractTextPlugin('web/css/main.css'),
        ]
    });
}
