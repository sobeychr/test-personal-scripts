'use strict';

module.exports = grunt => {

    return {
        options: {
            sourceMap: true
        },
        dist: {
            files: [{
                expand: true,
                cwd: './asset/css/',
                src: ['**/*.css'],
                dest: './asset/css/',
                ext: '.css'
            }]
        }
    };
};
