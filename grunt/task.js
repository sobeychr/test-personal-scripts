'use strict';

module.exports = grunt => {
    // Set configs
    var configs = {};
    const dirModule = grunt.config.get('dirModule'),
          dirTask   = grunt.config.get('dirTask');

    // Loads modules
    const module = {
            'cssmin': 'grunt-contrib-cssmin',
            'sass'  : 'grunt-sass',
            'watch' : 'grunt-contrib-watch'
        };
    for(let command in module)
    {
        let filename = command + '.js',
            task = module[command];

        configs[command] = require(dirModule + filename)(grunt);
        grunt.loadNpmTasks(task);
    }

    // Loads tasks
    grunt.file.recurse('./grunt/' + dirTask, (abspath, rootdir, subdir, filename) => {
        require(dirTask + filename)(grunt);
    });

    return configs;
};
