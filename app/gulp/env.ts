const {noop} = require('gulp-util');
const argv = require('gulp-util').env;

export const production:boolean = argv.env === 'prod';
export const watch:boolean = argv._.indexOf('watch') !== -1 || argv.watch;
export const angularCompile = true === argv['angular-compile'];

export const pipeIfDev = function(streamProvider:Function):NodeJS.WritableStream {
    return production ? noop() : streamProvider();
};

