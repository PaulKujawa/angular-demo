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
            new webpack.optimize.CommonsChunkPlugin({
                name: 'vendor',
                chunks: ['main'],
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
                Translator: path.join('web/bundles/bazingajstranslation/js/translator.min.js'),
            }),
        ],
        resolve: {
            extensions: ['.ts', '.js', '.scss'],
            plugins: [
                // plugin provides support for tsConfig's BaseUrl & Path, that are used for relative ES6 imports
                new TsConfigPathsPlugin({
                    configFileName: `${jsPath}/tsconfig.json`,
                }),
            ],
        },
    };

    if (args.analyze) {
        commonConfig.plugins.push(new BundleAnalyzerPlugin());
    }

    return commonConfig;
};
