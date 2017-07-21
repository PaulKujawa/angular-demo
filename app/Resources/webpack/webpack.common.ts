import {Configuration} from 'webpack';
import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
import {WebpackArgs} from './webpack-args';
const webpack = require('webpack');
const path = require('path');
const {TsConfigPathsPlugin} = require('awesome-typescript-loader');

export function getCommonConfig(args: WebpackArgs): Configuration {
    const rootPath = path.join(__dirname, '../../../');

    const commonConfig: Configuration = {
        context: path.join(__dirname, '../public/js'),
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

            // alternative to global variables. Imports the module JIT when the variable is used
            new webpack.ProvidePlugin({
                // e.g. for bootstrap-sass package
                jQuery: 'jquery',

                // since Bazinga's dumped translation files require Translator in global namespace
                Translator: 'web/bundles/bazingajstranslation/js/translator.min.js',
            }),
        ],
        resolve: {
            extensions: ['.ts', '.js', '.scss'],
            plugins: [
                // provide support for 'paths' and 'baseUrl' settings in tsconfig.json
                new TsConfigPathsPlugin(),
            ],
        },
    };

    if (args.analyze) {
        // chunk analyzation
        commonConfig.plugins.push(new BundleAnalyzerPlugin());
    }

    return commonConfig;
}
