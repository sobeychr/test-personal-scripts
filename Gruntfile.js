'use strict';

module.exports = grunt => {
    require('./grunt/functions.js')(grunt);
    require('./grunt/configs.js')(grunt);
    
    const pkg = grunt.file.readJSON('./package.json');

    const now = grunt.config.get('setupDate'),
          taskConfigs = require( grunt.config.get('fileTask') )(grunt);

    taskConfigs.pkg = pkg;
    taskConfigs.date = now;

    grunt.config.init(taskConfigs);
};
