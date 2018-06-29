/**
 * imports
 *  - vendors (core-js, zone.js and zone.js-patch)
 *  - angular getTestBed().initTestEnvironment()
 *  - AngularSnapshotSerializer & HTMLCommentSerializer TODO clarify
 */
import 'jest-preset-angular';

// to go along with webpack
declare let global: any;
global.environment = {
    test: true,
};

Object.defineProperty(window, 'appInject', {value: () => ({})});
