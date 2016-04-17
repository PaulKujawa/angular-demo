const {env} = require('gulp-util');
const {noop} = require('gulp-util');

export const production:boolean = env.env === 'prod';

export const pipeIfDev = function(streamProvider:Function):NodeJS.WritableStream {
    return production ? noop() : streamProvider();
};

