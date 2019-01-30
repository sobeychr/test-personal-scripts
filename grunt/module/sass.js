'use strict';

module.exports = grunt => {

    const sass = require('node-sass');

    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln('watching - ', action, filepath, target);
    });

    return {
        options: {
            includePaths: [
                './asset/scss/global/'
            ],
            implementation: sass,
            precision: 3,
            sourceMap: true
        },
        dist: {
            files: [{
                expand: true,
                cwd: './asset/scss/',
                src: ['**/*.scss'],
                dest: './asset/css/',
                ext: '.css'
            }]
        }
    };
};
