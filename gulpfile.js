var tsNodeRegister = require('ts-node').register;
var tasks = [
   // 'angular-compile', TODO
    'build',
    'jspm',
    'sass',
    'symfony',
    'ts',
    'watch'
];

tsNodeRegister({
    fast: true,
    noProject: true
});

tasks.forEach(function(filename) {
   require('./app/gulp/task/' + filename + '.ts');
});
