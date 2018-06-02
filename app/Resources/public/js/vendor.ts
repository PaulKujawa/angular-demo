/**
 * Used as an webpack entry point, that loads modules, that aren't loaded in the main entry point (app).
 * These modules are obviously loaded enitely and therefore not optimized by tree shaking.
 */

/*
 * Override baseUrl for lazy loaded assets like images and js-chunks
 * Original baseUrl is set in base template
 */
if (process.env.NODE_ENV !== 'test') {
    __webpack_public_path__ = '/';
}

// polyfills
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
