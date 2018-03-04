import {Configuration} from 'webpack';
import {WebpackArgs} from './webpack-args';
const webpack = require('webpack');
const path = require('path');
const ManifestPlugin = require('webpack-manifest-plugin');

export const getCommonConfig = (args: WebpackArgs): Configuration => {
    return {
        context: path.resolve(__dirname, '../public/js'),
        entry: './main.ts',
        output: {
            path: path.resolve(__dirname, '../../../web'),
            filename: 'js/bundle/[name].[hash].js',
            chunkFilename: 'js/chunk/[name].[chunkhash].js',
        },
        plugins: [
            new ManifestPlugin(),

            // set global variables
            new webpack.DefinePlugin({
                'process.env': {
                    ENV: JSON.stringify(args.env),
                },
            }),

            // when these variables are used, an ES6 import is automatically added
            // add module declarations via type definitions files to provide type checks
            new webpack.ProvidePlugin({
                Translator: path.join('web/bundles/bazingajstranslation/js/translator.min.js'),
            }),
        ],
        // @ts-ignore
        optimization: {
            splitChunks: {
                cacheGroups: {
                    commons: {
                        test: /[\\/]node_modules[\\/]/,
                        name: 'vendor',
                        chunks: 'all',
                    },
                },
            },
        },
        resolve: {
            extensions: ['.ts', '.js', '.scss'],
        },
    };
};
