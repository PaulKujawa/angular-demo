const fs = require('fs-extra');
export const Promise = require('bluebird');
export const remove = Promise.promisify(fs.remove);
export const ensureSymlink = Promise.promisify(fs.ensureSymlink);
export const readDir = Promise.promisify(fs.readdir);
