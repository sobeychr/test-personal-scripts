'use strict';

module.exports = grunt => {

    grunt.registerTask('default', () => {
        grunt.log.writeln('No grunt task selected'['red']);
        grunt.log.writeln('> add --mo='['cyan'] + '[module]'['yellow'], 'Automatically adds a new page/module');
        grunt.log.writeln('> remove --mo='['cyan'] + '[module]'['yellow'], 'Removed an existing page/module');
        grunt.log.writeln('> run'['cyan'], 'Builds and Watch content');
    });

    return {};
};
