import '../../vendor';
import 'zone.js/dist/long-stack-trace-zone';
import 'zone.js/dist/proxy';
import 'zone.js/dist/sync-test';
import 'zone.js/dist/jasmine-patch';
import 'zone.js/dist/async-test';
import 'zone.js/dist/fake-async-test';
import {TestBed} from '@angular/core/testing';
import {BrowserDynamicTestingModule, platformBrowserDynamicTesting} from '@angular/platform-browser-dynamic/testing';

window.appInject = {}; // set symfony imports

Error.stackTraceLimit = Infinity;

__karma__.loaded = function() {};

TestBed.initTestEnvironment(BrowserDynamicTestingModule, platformBrowserDynamicTesting());

// Create own webpack context aka test bundle
const context = require.context('../app', true, /\.spec\.ts$/);
context.keys().map(context);

__karma__.start();
