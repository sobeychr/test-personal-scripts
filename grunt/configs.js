'use strict';

module.exports = grunt => {
    const setConfigs = grunt.config.get('setConfigs');

    const configs = {
        'setup': {
            'date' : grunt.template.today('yyyy-mm-dd HH:MM::ss'),
        },
        'file': {
            'env'  : './env.js',
            'task' : './grunt/task.js'
        },
        'dir': {
            'module' : './module/',
            'task'   : './task/'
        }
    };

    setConfigs('', configs);

    require('./env.js')(grunt);

    return {};
};