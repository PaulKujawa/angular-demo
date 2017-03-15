const merge = require('webpack-merge');
import {commonConfig} from './webpack.common';

export function webpackConfig(args: Object) {
    const env = process.env.ENV = process.env.NODE_ENV;

    return merge(commonConfig({env: env}), {
        devtool: 'inline-source-map',
        module: {
            rules: [
                {
                    // write templates inline and transpile ts to js
                    test: /\.ts$/, loaders: ['awesome-typescript-loader', 'angular2-template-loader']
                }, {
                    // do not load (s)css
                    test: /\.scss$/, loader: 'null-loader'
                }, {
                    // do not load images
                    test: /\.(png|jpe?g|gif|svg|woff|woff2|ttf|eot|ico)$/, loader: 'null-loader'
                },
            ]
        },
        plugins: [],
        resolve: {
            extensions: ['.ts', '.js'] // no .scss
        }
    })
}
