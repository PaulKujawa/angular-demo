import {production} from "./env";
const shell = require('gulp-shell');
const util = require('gulp-util');

export const exec = (command: 'jspm'|'tsc'|'ngc', args: string[], consoleLog: boolean = true): Promise<any> => {
    const command = ['node_modules/.bin/' + command].concat(args).join(' ');

    return new Promise((resolve, reject) => {
        shell.task(command, {}) ((error) => {
            if (error && consoleLog) {
                console.error(error.message);
                console.error(error.stderr);

                if (production) {
                    reject(error);

                    return;
                }
            }
            resolve();
        });
    });
};
