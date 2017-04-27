/**
 * Used as an webpack entry point, that loads modules, that aren't loaded in the main entry point (app).
 * These modules are obviously loaded enitely and therefore not optimized by tree shaking.
 */

// polyfills
// TODO use DLLs instead
import 'core-js/es6/array';
import 'core-js/es6/date';
import 'core-js/es6/function';
import 'core-js/es6/map';
import 'core-js/es6/math';
import 'core-js/es6/number';
import 'core-js/es6/object';
import 'core-js/es6/parse-float';
import 'core-js/es6/parse-int';
import 'core-js/es6/reflect';
import 'core-js/es6/regexp';
import 'core-js/es6/set';
import 'core-js/es6/string';
import 'core-js/es6/symbol';
import 'core-js/es6/typed';
import 'core-js/es6/weak-map';
import 'core-js/es6/weak-set';
import 'core-js/es7/reflect';
import 'zone.js/dist/zone';

// RxJS
import 'rxjs/add/observable/merge';
import 'rxjs/add/observable/of';
import 'rxjs/add/observable/throw';

import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/debounceTime';
import 'rxjs/add/operator/distinctUntilChanged';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/filter';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/merge';
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/operator/take';

// see webpack ProvidePlugin
import 'jquery';
// tslint:disable-next-line:ordered-imports
import 'bootstrap-sass/assets/javascripts/bootstrap';
