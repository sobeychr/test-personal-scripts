'use strict';

module.exports = grunt => {

    return {
        options: {
            livereload: true
        },
        css: {
            files: ['asset/scss/**/*.scss'],
            tasks: ['sass']
        }
    };
};
