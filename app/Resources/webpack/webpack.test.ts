import {WebpackArgs} from './webpack-args';
import {commonConfig} from './webpack.common';
const merge = require('webpack-merge');

export function webpackConfig(args: WebpackArgs) {
    return merge(commonConfig(args), {
        devtool: 'inline-source-map',
        module: {
            rules: [
                {
                    // write templates inline and transpile ts to js
                    test: /\.ts$/, loaders: ['awesome-typescript-loader', 'angular2-template-loader'],
                }, {
                    // do not load (s)css
                    test: /\.scss$/, loader: 'null-loader',
                }, {
                    // do not load images
                    test: /\.(png|jpe?g|gif|svg|woff|woff2|ttf|eot|ico)$/, loader: 'null-loader',
                },
            ],
        },
        plugins: [],
        resolve: {
            extensions: ['.ts', '.js'], // no .scss
        },
    });
}
