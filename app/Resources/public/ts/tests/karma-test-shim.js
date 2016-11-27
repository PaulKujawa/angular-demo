Error.stackTraceLimit = 0;
jasmine.DEFAULT_TIMEOUT_INTERVAL = 1000;
__karma__.loaded = function () {};

System.config({
    transpiler: false,
    packages: {
        app: {
            defaultExtension: 'js'
        },
        tests: {
            defaultExtension: 'js'
        }
    }
});

System.import('app/rxjs')
    .then(initTestBed)
    .then(initTesting)
    .then(
        __karma__.start.bind(__karma__),
        console.error.bind(console)
    );

function initTestBed() {
    return Promise.all([
        System.import('@angular/core/testing'),
        System.import('@angular/platform-browser-dynamic/testing')
    ]).then(function (providers) {
        providers[0].TestBed.initTestEnvironment(
            providers[1].BrowserDynamicTestingModule,
            providers[1].platformBrowserDynamicTesting()
        );
    })
}

function initTesting() {
    var allSpecFiles = Object.keys(__karma__.files)
        .filter(function(importPath) {
            return /\/tests\/.+\.spec\.js$/.test(importPath);
        }).map(function(importPath) {
            // 'app-tests' according to package identifier in config.js
            return importPath.replace(/^\/base\/app\/Resources\/public\/ts\/tests\/(.+)\.js/, 'app-tests/$1');
        });

    return Promise.all(allSpecFiles.map(function (moduleName) {
        return System.import(moduleName);
    }));
}
