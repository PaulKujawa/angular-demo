const {env} = require('gulp-util');
const {noop} = require('gulp-util');

export const production:boolean = env.env === 'prod';
export const verbose:boolean = env.verbose;
export const watch:boolean = env.watch;

export const pipeIfDev = function(streamProvider:Function):NodeJS.WritableStream {
    return production ? noop() : streamProvider();
};

