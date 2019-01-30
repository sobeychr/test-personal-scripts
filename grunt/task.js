'use strict';

module.exports = grunt => {
    const module = {
            'sass': 'grunt-sass',
            'watch': 'grunt-contrib-watch'
        };

    var configs = {};

    for(let command in module)
    {
        let filename = command + '.js',
            task = module[command];

        configs[command] = require('./module/' + filename)(grunt);
        grunt.loadNpmTasks(task);
    }

    return configs;
};
