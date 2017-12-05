import {enableProdMode} from '@angular/core';
import {platformBrowserDynamic} from '@angular/platform-browser-dynamic';
import {AppModule} from './app/app.module';

/*
 * import own vendors: routes, css (translations are loaded JIT)
 */
import 'web/bundles/fosjsrouting/js/router';
import 'web/js/fos_js_routes';
require('../css/main.scss');

if (process.env.ENV === 'prod') {
    enableProdMode();
}

// will be replaced JIT by @ngtools/webpack/src/loader.js for angular AOT in production
platformBrowserDynamic().bootstrapModule(AppModule);
