'use strict';

module.exports = grunt => {

    grunt.registerTask('default', 'running default grunt', () => {
        grunt.log.writeln('testing');
    });

    return {};
};
