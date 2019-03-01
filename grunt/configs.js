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

    const addRemove = {
            'script.js'  : 'asset/js/page/{mo}.js',
            'style.scss' : 'asset/scss/page/{mo}.scss',
            'setup.json' : 'include/setup/page/{mo}.json',
            'view.php'   : 'include/view/page/{mo}.php'
        };
    grunt.config.set('addRemove', addRemove);

    require('./env.js')(grunt);

    return {};
};