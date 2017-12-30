import {Configuration} from 'webpack';
import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
import {WebpackArgs} from './webpack-args';
const webpack = require('webpack');
const path = require('path');
const {TsConfigPathsPlugin} = require('awesome-typescript-loader');

export const getCommonConfig = (args: WebpackArgs): Configuration => {
    const rootPath = path.join(__dirname, '../../../');
    const jsPath = path.join(__dirname, '../public/js');

    const commonConfig: Configuration = {
        context: jsPath,
        entry: {
            main: './main.ts',
            vendor: './vendor.ts',
        },
        module: {
            rules: [
                {
                    test: /\.html$/, loader: 'html-loader',
                },
            ],
        },
        output: {
            path: rootPath + 'web/', // is used for both bundles and chunks
            filename: 'js/bundle/[name].js',
            chunkFilename: 'js/chunk/[name].js',
        },
        plugins: [
            /**
             * Creates bundles and chunks.
             *
             * A bundle emerges from an entry point, containing all its files
             * A chunk is used:
             *  - by angular for lazy loaded ng-modules
             *  - by webpack for modules, that are shared among entry points (e.g. vendors)
             */
            new webpack.optimize.CommonsChunkPlugin({
                name: 'vendor', // common chunk, where shared modules get imported
                chunks: ['main'], // source chunks, child of common chunk
                minChunks: (module) => /(node_modules|web\/js|web\/)\//.test(module.resource),
            }),

            // set global variables
            new webpack.DefinePlugin({
                'process.env': {
                    ENV: JSON.stringify(args.env),
                },
            }),

            // when these variables are used, an ES6 import is automatically added
            // this lets them behave like globally declared variables
            // add module declarations via type defintions files to provide type checks
            new webpack.ProvidePlugin({
                Translator: 'web/bundles/bazingajstranslation/js/translator.min.js',
            }),
        ],
        resolve: {
            extensions: ['.ts', '.js', '.scss'],
            plugins: [
                // plugin provides support for tsConfig's Path and BaseUrl, that are used for relative ES6 imports
                new TsConfigPathsPlugin({
                    configFileName: `${jsPath}/tsconfig.json`,
                }),
            ],
        },
    };

    if (args.analyze) {
        // chunk analyzation
        commonConfig.plugins.push(new BundleAnalyzerPlugin());
    }

    return commonConfig;
};
