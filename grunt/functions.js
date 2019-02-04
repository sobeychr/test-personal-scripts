'use strict';

module.exports = grunt => {
    const ucFirst = string => string.charAt(0).toUpperCase() + string.slice(1);

    const setConfigs = (rootname, configs) => {
        for(let label in configs)
        {
            let value = configs[label],
                name  = rootname + ucFirst(label);
            if(typeof(value) === 'string' || typeof(value) === 'number') {
                grunt.config.set(name, value);
                //grunt.log.writeln('> ', name, value);
            }
            else {
                setConfigs(rootname + label, value);
            }
        }
    };

    grunt.config.set('ucFirst',    ucFirst);
    grunt.config.set('setConfigs', setConfigs);

    return {};
};