'use strict';

module.exports = grunt => {

    const isDev = grunt.config.get('isDev'),
          now = grunt.config.get('setupDate');

    grunt.registerTask('default', () => {
        grunt.log.writeln('>> launched on'['green'], now);
        grunt.log.writeln('>> isDev:'['cyan'], isDev);

        let tasks = ['sass'];

        if(isDev) {
            tasks.push('watch:dev');
        }

        grunt.task.run(tasks);
    });

    return {};
};
