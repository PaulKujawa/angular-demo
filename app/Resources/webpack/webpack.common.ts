import {BundleAnalyzerPlugin} from 'webpack-bundle-analyzer';
import {WebpackArgs} from './webpack-args';
const webpack = require('webpack');
const path = require('path');
const {TsConfigPathsPlugin} = require('awesome-typescript-loader');

export function commonConfig(args: WebpackArgs) {
    const rootPath = path.join(__dirname, '../../../');

    const config = {
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
            path: rootPath,
            filename: 'web/js/[name].js',
        },
        plugins: [
            // Moves shared imports of source chunk 'main' and its children into common chunk 'vendor'
            new webpack.optimize.CommonsChunkPlugin({
                names: ['main', 'vendor'],
                // name: 'vendor', TODO as soon as multiple chunks are generated, this can be exchanged/enabled
                // chunks: ['main'],
                // children: true,
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

            // see https://github.com/angular/angular/issues/11580
            new webpack.ContextReplacementPlugin(
                /angular(\\|\/)core(\\|\/)@angular/,
                path.resolve(__dirname, 'doesnotexist/'),
            ),
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
        config.plugins.push(new BundleAnalyzerPlugin());
    }

    return config;
}
