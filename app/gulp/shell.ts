const shell = require('gulp-shell');
const util = require('gulp-util');

export const exec = (command: 'jspm'|'tsc', args: string[]): Promise => {
    const command = ['node_modules/.bin/' + command].concat(args).join(' ');

    return new Promise((resolve) => {
        shell.task(command, {})((error) => {
            if (error) {
                console.error(error.message);
                console.error(error.stderr);
            }
            resolve();
        });
    });
};
