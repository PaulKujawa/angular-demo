var tsNodeRegister = require('ts-node').register;
var tasks = [
    'build',
    'jspm',
    'sass',
    'symfony',
    'ts',
    'watch'
];

tsNodeRegister({
   disableWarnings: true
});

tasks.forEach(function(filename) {
   require('./app/gulp/task/' + filename + '.ts');
});
