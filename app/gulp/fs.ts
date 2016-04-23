const fs = require('fs-extra');
export const Promise = require('bluebird');
export const remove = Promise.promisify(fs.remove);
