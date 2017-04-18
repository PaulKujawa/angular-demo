const webpack = require('webpack');
const path = require('path');
const {TsConfigPathsPlugin} = require('awesome-typescript-loader');
import WebpackArguments from './webpack-arguments';

export function commonConfig(args: WebpackArguments) {
    const rootPath = path.join(__dirname, '../../../');

    return {
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
            ]
        },
        output: {
            path: rootPath,
            filename: 'web/js/[name].js',
        },
        plugins: [
            // when two chunks (= entries) hold the same dependency, drop it to the more steady chunk.
            new webpack.optimize.CommonsChunkPlugin({
                name: ['main', 'vendor'],
            }),

            // set global variables
            new webpack.DefinePlugin({
                'process.env': {
                    ENV: JSON.stringify(args.env),
                    NODE_ENV: JSON.stringify(args.env),
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
}
