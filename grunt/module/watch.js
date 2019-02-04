'use strict';

module.exports = grunt => {

    return {
        options: {
            livereload: true
        },
        dev: {
            files: ['asset/scss/**/*.scss'],
            tasks: ['sass']
        },
        stage: {
            files: ['asset/scss/**/*.scss'],
            tasks: ['sass', 'cssmin']
        }
    };
};
