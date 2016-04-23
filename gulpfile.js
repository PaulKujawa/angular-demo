var tsNodeRegister = require('ts-node').register;
var tasks = [
    'build',
    'sass',
    'symfony',
    'watch'
];

tsNodeRegister({
   disableWarnings: true
});

tasks.forEach(function(filename) {
   require('./app/gulp/task/' + filename + '.ts');
});
