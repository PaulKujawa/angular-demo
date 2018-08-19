import {Configuration} from 'webpack';
const webpack = require('webpack');
const path = require('path');
const ManifestPlugin = require('webpack-manifest-plugin');

/*
 * merged with configuration for development or production
 */
export const getCommonConfig = (): Configuration => ({
    context: path.resolve(__dirname, '../public/js'),
    entry: {
        // based on context option above
        // one entry point per HTML page. SPA: one entry point, MPA: multiple entry points.
        main: './main.ts',
        styles: '../css/styles.scss',
    },
    output: {
        path: path.resolve(__dirname, '../../../web'),
        filename: 'js/bundle/[name].[hash].js',
        chunkFilename: 'js/chunk/[name].[chunkhash].js',
    },
    plugins: [
        new ManifestPlugin(),

        /*
         * To have access to variables like they are globally provided
         * Add module declarations via type definitions files to provide type checks
         */
        new webpack.ProvidePlugin({
            Translator: path.join('web/bundles/bazingajstranslation/js/translator.min.js'),
            // Routing from symfony writes itself into window.
        }),
    ],
    optimization: {
        splitChunks: {
            chunks: 'all',
            maxInitialRequests: 6,
            cacheGroups: {
                rxjs: {
                    test: /[\\/]node_modules[\\/]rxjs[\\/]/,
                    name: 'rxjs',
                },
                zonejs: {
                    test: /[\\/]node_modules[\\/]zone\.js[\\/]/,
                    name: 'zone-js',
                },
                coreJs: {
                    test: /[\\/]node_modules[\\/]core-js[\\/]/,
                    name: 'core-js',
                },
                material: {
                    test: /[\\/]node_modules[\\/]@angular[\\/](material|cdk)[\\/]/,
                    priority: -8,
                    name: 'angular-material',
                },
                angular: {
                    test: /[\\/]node_modules[\\/]@angular[\\/]/,
                    priority: -10,
                    name: 'angular',
                },
                vendor: {
                    // currently unused due to minSize of 30KB
                    test: /[\\/]node_modules[\\/]/,
                    priority: -20,
                    name: 'vendor',
                },
            },
        } as any,
    },
    resolve: {
        extensions: ['.ts', '.js'],
    },
});
