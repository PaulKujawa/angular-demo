const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const path = require('path');
const {AotPlugin} = require('@ngtools/webpack');
import {commonConfig} from './webpack.common';

export function webpackConfig(args: object) {
    const rootPath = path.join(__dirname, '../../..');
    const jsPath = path.join(rootPath, 'app/Resources/public/js');
    const env = process.env.ENV = process.env.NODE_ENV;

    return merge(commonConfig({env: env}), {
        devtool: 'source-map',
        module: {
            rules: [
                {
                    // write templates inline and transpile ts to js TODO more precise description
                    test: /\.ts$/, loader: '@ngtools/webpack',
                }, {
                    // transpile sass to css and load it as extra file separately
                    test: /\.scss$/,
                    loader: ExtractTextPlugin.extract({
                        use: [
                            {loader: 'css-loader', options: {sourceMap: true}},
                            {loader: 'sass-loader', options: {sourceMap: true}},
                        ],
                    }),
                },
            ],
        },
        plugins: [
            new AotPlugin({
                tsConfigPath: 'tsconfig.json',
                entryModule: path.join(jsPath, 'app/app.module#AppModule'),
            }),

            // generate separate css file to load
            new ExtractTextPlugin('web/css/main.css'),

            // stop the build if there is an error
            new webpack.NoEmitOnErrorsPlugin(),

            // minimizer
            new webpack.optimize.UglifyJsPlugin(),
        ],
    });
}
