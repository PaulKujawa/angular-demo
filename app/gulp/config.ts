import {production} from './env'

export const resources = 'app/Resources/public/';
export const output = 'web/';

export const sass = {
    build: {
        // construct destination tree from 'scss/'
        base: `${resources}scss`,
        source: [
            `${resources}scss/app/**/*.scss`,
            `!**/import/**/*.scss`,
            `!**/import/*.scss`,
        ],
        destination: `${output}css`,
        compilerOptions: {
            includePaths: [resources],
            outputStyle: production ? 'compressed' : 'nested'
        }
    },
    clean: `${output}css`,
    concat: {
        source: [
            `${output}css/app__main.css`,
            `${output}css/app__*.css`,
        ],
        destination: `${output}css/app.css`
    },
    watch: `${resources}scss/**/*.scss`
};
