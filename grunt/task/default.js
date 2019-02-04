'use strict';

module.exports = grunt => {

    const isDev = grunt.config.get('isDev');

    grunt.registerTask('default', () => {
        let tasks = ['sass'];

        if(isDev) {
            tasks.push('watch:dev');
        }

        grunt.task.run(tasks);
    });

    return {};
};
