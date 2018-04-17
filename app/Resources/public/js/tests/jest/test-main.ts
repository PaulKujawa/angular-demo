/**
 * imports
 *  - vendors (core-js, zone.js and zone.js-patch)
 *  - angular getTestBed().initTestEnvironment()
 *  - AngularSnapshotSerializer & HTMLCommentSerializer TODO clarify
 */
import 'jest-preset-angular';
import '../../vendor.ts';

Object.defineProperty(window, 'appInject', {value: () => ({})});
