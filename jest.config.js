module.exports = {
    "preset": "jest-preset-angular",
    "collectCoverage": true,
    "coverageReporters": [
        "lcov",
        "html"
    ],
    "coveragePathIgnorePatterns": [
        "<rootDir>/app/Resources/public/js/tests/",
        "<rootDir>/node_modules/"
    ],
    "collectCoverageFrom": [
        "**/app/Resources/public/js/app/**/*.ts"
    ],
    "globals": {
        "ts-jest": {
            "tsConfigFile": "app/Resources/public/js/tests/tsconfig.json"
        },
        "__TRANSFORM_HTML__": true
    },
    "moduleNameMapper": {
        "^app/(.*)": "<rootDir>/app/Resources/public/js/app/$1",
        "^web/bundles/.*": "<rootDir>/app/Resources/public/js/tests/jest/empty.js",
        "^web/js/.*": "<rootDir>/app/Resources/public/js/tests/jest/empty.js"
    },
    "setupTestFrameworkScriptFile": "./app/Resources/public/js/tests/jest/test-main.ts",
    "testMatch": [
        "**/app/Resources/public/js/tests/app/**/*.spec.ts"
    ]
};
