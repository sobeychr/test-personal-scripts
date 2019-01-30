'use strict';

module.exports = grunt => {
    const pkg = grunt.file.readJSON('package.json');

    const now = grunt.template.today("yyyy-mm-dd HH:MM::ss"),
          taskConfigs = require('./grunt/task.js')(grunt);

    taskConfigs.pkg = pkg;
    taskConfigs.date = now;

    grunt.config.init(taskConfigs);

    grunt.registerTask('default', 'running default grunt', ['sass', 'watch']);
};
